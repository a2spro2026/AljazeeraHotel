<?php

namespace App\Http\Controllers;

use App\Models\HotelUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HotelUserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorizeManager($request);

        return response()->json(['users' => $this->list()]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorizeManager($request);

        $existing = $request->filled('edit')
            ? HotelUser::where('code', $request->input('edit'))->firstOrFail()
            : null;

        $kind = $request->input('kind', $existing?->kind ?: 'user');
        if (! in_array($kind, ['user', 'commercial'], true)) {
            $kind = 'user';
        }

        $reserved = collect(config('admin_spaces'))
            ->pluck('login')
            ->filter()
            ->map(fn ($login) => mb_strtolower((string) $login))
            ->all();

        $allowedProfils = $kind === 'commercial' ? HotelUser::COMM_PROFILS : HotelUser::USER_PROFILS;

        $data = $request->validate([
            'fiche_date' => ['nullable', 'date'],
            'nom' => ['required', 'string', 'max:255'],
            'cin' => ['nullable', 'string', 'max:30'],
            'tel' => ['nullable', 'string', 'max:30'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'profil' => ['required', Rule::in($allowedProfils)],
            'contrat' => ['nullable', Rule::in(HotelUser::CONTRATS)],
            'debut' => ['nullable', 'date'],
            'fin' => ['nullable', 'date', 'after_or_equal:debut'],
            'formation' => ['nullable', 'string', 'max:255'],
            'salaire' => ['nullable', 'numeric', 'min:0'],
            'login' => [
                'required', 'string', 'min:3', 'max:60', 'regex:/^[\p{L}0-9._@-]+$/u',
                Rule::unique('hotel_users', 'login')->ignore($existing?->id),
                function (string $attribute, mixed $value, \Closure $fail) use ($reserved) {
                    if (in_array(mb_strtolower((string) $value), $reserved, true)) {
                        $fail('Ce login est réservé.');
                    }
                },
            ],
            'password' => [$existing ? 'nullable' : 'required', 'string', 'min:6', 'max:100'],
            'photo' => ['nullable', 'string'],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'profil.required' => 'Le profil est obligatoire.',
            'profil.in' => 'Profil invalide.',
            'contrat.in' => 'Type de contrat invalide.',
            'debut.date' => 'Date de début invalide.',
            'fin.date' => 'Date de fin invalide.',
            'fin.after_or_equal' => 'La date de fin doit être après la date de début.',
            'salaire.numeric' => 'Salaire invalide.',
            'salaire.min' => 'Salaire invalide.',
            'login.required' => 'Le login est obligatoire.',
            'login.min' => 'Le login doit contenir au moins 3 caractères.',
            'login.max' => 'Le login est trop long.',
            'login.regex' => 'Le login ne peut contenir que des lettres, chiffres, point, tiret, _ ou @.',
            'fiche_date.date' => 'Date invalide.',
            'login.unique' => 'Ce login est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.max' => 'Le mot de passe est trop long.',
        ]);

        $data['kind'] = $kind;
        $data['fiche_date'] = $data['fiche_date'] ?? now()->toDateString();
        $data = array_merge(
            array_fill_keys(['cin', 'tel', 'adresse', 'contrat', 'debut', 'fin', 'formation', 'salaire'], null),
            $data
        );

        // Compte Direction : pas de fiche RH (contrat / dates / formation / salaire).
        if (($data['profil'] ?? null) === 'Direction') {
            $data['contrat'] = null;
            $data['debut'] = null;
            $data['fin'] = null;
            $data['formation'] = null;
            $data['salaire'] = null;
        }

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = trim($data['password']);
        }

        if (! array_key_exists('photo', $data) || $data['photo'] === null || $data['photo'] === '') {
            unset($data['photo']);
        }

        if ($existing) {
            $existing->update($data);
        } else {
            HotelUser::create($data + ['code' => $this->nextCode($kind)]);
        }

        return response()->json(['users' => $this->list()]);
    }

    public function saveAuth(Request $request, string $code): JsonResponse
    {
        $this->authorizeManager($request);

        $user = HotelUser::where('code', $code)->firstOrFail();
        $data = $request->validate([
            'autorisations' => ['required', 'array'],
            'autorisations.*' => ['array'],
            'autorisations.*.saisir' => ['boolean'],
            'autorisations.*.modifier' => ['boolean'],
            'autorisations.*.supprimer' => ['boolean'],
            'autorisations.*.imprimer' => ['boolean'],
            'autorisations.*.voir' => ['boolean'],
        ]);
        $user->update(['autorisations' => $data['autorisations']]);

        return response()->json(['users' => $this->list()]);
    }

    public function destroy(Request $request, string $code): JsonResponse
    {
        $this->authorizeManager($request);

        $user = HotelUser::where('code', $code)->firstOrFail();
        abort_if(
            strcasecmp($user->login, (string) $request->session()->get('space_admin_login')) === 0,
            422,
            'Vous ne pouvez pas supprimer votre propre compte.'
        );
        $user->delete();

        return response()->json(['users' => $this->list()]);
    }

    private function authorizeManager(Request $request): void
    {
        $session = $request->session();
        $profil = $session->get('space_admin_profil');
        $isManager = $session->get('space_admin') && ($profil !== null
            ? in_array($profil, ['Direction', 'Administration'], true)
            : in_array($session->get('space_admin_login'), config('admin_spaces.admin.manager_logins', []), true));

        abort_unless($isManager, 403, 'Gestion des utilisateurs réservée à la Direction.');
    }

    private function list(): array
    {
        return HotelUser::orderBy('code')->get()->map->toAdminArray()->all();
    }

    private function nextCode(string $kind = 'user'): string
    {
        $prefix = $kind === 'commercial' ? 'Co' : 'Ut';
        $max = HotelUser::pluck('code')
            ->map(fn ($code) => preg_match('/^'.$prefix.'(\d+)$/i', $code, $m) ? (int) $m[1] : 0)
            ->max() ?? 0;

        return $prefix.str_pad((string) ($max + 1), 4, '0', STR_PAD_LEFT);
    }
}
