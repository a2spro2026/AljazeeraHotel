<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/chambres', 'chambres')->name('chambres');
Route::view('/services', 'services')->name('services');
Route::view('/restaurant', 'restaurant')->name('restaurant');
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
            ->with('login_error', 'Identifiant obsolète. Utilisez : '.$config['login']);
    }

    if ($credentials['login'] === $config['login'] && $credentials['password'] === $config['password']) {
        $request->session()->put("space_$space", true);
        $request->session()->put("space_{$space}_login", $config['login']);

        return redirect()->route($config['route']);
    }

    return redirect()->route('home')
        ->with('login_space', $space)
        ->with('login_error', 'Identifiant ou mot de passe incorrect.');
})->name('space.login');

// Déconnexion d'un espace
Route::post('/espace/{space}/logout', function (Request $request, string $space) {
    $request->session()->forget("space_$space");
    $request->session()->forget("space_{$space}_login");

    return redirect()->route('home');
})->name('space.logout');

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

        return view($view);
    })->name($name);
}
