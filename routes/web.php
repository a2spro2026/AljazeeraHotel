<?php

use App\Http\Controllers\HotelUserController;
use App\Models\HotelUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/chambres', 'chambres')->name('chambres');
Route::view('/services', 'services')->name('services');
Route::view('/restaurant', 'restaurant')->name('restaurant');
Route::view('/galerie', 'galerie')->name('galerie');
Route::view('/apropos', 'apropos')->name('apropos');
Route::view('/calendrier', 'calendrier')->name('calendrier');

Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', function () {
    return redirect()->route('contact')->with('sent', true);
})->name('contact.send');

/*
|--------------------------------------------------------------------------
| Espaces d'administration protégés (Direction / Facturation / Commercial)
|--------------------------------------------------------------------------
*/

// Connexion à un espace
Route::post('/espace/{space}/login', function (Request $request, string $space) {
    $config = config("admin_spaces.$space");
    abort_if(! $config, 404);

    $credentials = $request->validate([
        'login'    => 'required|string',
        'password' => 'required|string',
    ]);

    $legacyLogins = ['khadija@gds.com'];
    if (in_array(strtolower($credentials['login']), array_map('strtolower', $legacyLogins), true)) {
        return redirect()->route('home')
            ->with('login_space', $space)
            ->with('login_error', 'Identifiant obsolète.');
    }

    $configured = filled($config['login']) && filled($config['password']);
    $loginOk = $configured && strcasecmp(trim($credentials['login']), (string) $config['login']) === 0;
    $passwordOk = $configured && hash_equals((string) $config['password'], trim($credentials['password']));

    if ($loginOk && $passwordOk) {
        $request->session()->regenerate();
        $request->session()->put("space_$space", true);
        $request->session()->put("space_{$space}_login", $config['login']);
        $request->session()->forget(["space_{$space}_profil", "space_{$space}_nom"]);

        return redirect()->route($config['route']);
    }

    $user = HotelUser::where('login', trim($credentials['login']))->first();
    if ($user && Hash::check(trim($credentials['password']), $user->password)) {
        if (! $user->canOpen($space)) {
            return redirect()->route('home')
                ->with('login_space', $space)
                ->with('login_error', "Votre profil ne donne pas accès à l'espace {$config['label']}.");
        }

        $request->session()->regenerate();
        $request->session()->put("space_$space", true);
        $request->session()->put("space_{$space}_login", $user->login);
        $request->session()->put("space_{$space}_profil", $user->profil);
        $request->session()->put("space_{$space}_nom", $user->nom);

        return redirect()->route($config['route']);
    }

    return redirect()->route('home')
        ->with('login_space', $space)
        ->with('login_error', 'Identifiant ou mot de passe incorrect.');
})->middleware('throttle:10,1')->name('space.login');

// Déconnexion d'un espace
Route::post('/espace/{space}/logout', function (Request $request, string $space) {
    $request->session()->forget(["space_$space", "space_{$space}_login", "space_{$space}_profil", "space_{$space}_nom"]);

    return redirect()->route('home');
})->name('space.logout');

// Utilisateurs de l'hôtel (gestion réservée à la Direction)
Route::prefix('admin/api/users')->controller(HotelUserController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::delete('/{code}', 'destroy');
});

// Pages protégées
$protected = [
    'admin'       => 'admin',
    'facturation' => 'facturation',
    'commercial'  => 'commercial',
];

foreach ($protected as $name => $view) {
    Route::get("/$view", function () use ($name, $view) {
        if (! session("space_$name")) {
            $label = config("admin_spaces.$name.label", $name);

            return redirect()->route('home')
                ->with('login_space', $name)
                ->with('login_error', "Veuillez vous connecter à l'espace $label.");
        }

        $storedLogin = session("space_{$name}_login");
        if ($name === 'admin' && $storedLogin && strcasecmp($storedLogin, 'khadija@gds.com') === 0) {
            session(['space_admin_login' => config('admin_spaces.admin.login', 'Direction')]);
        }

        return response()->view($view)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    })->name($name);
}
