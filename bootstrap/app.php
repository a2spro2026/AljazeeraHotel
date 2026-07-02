<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if ($request->is('espace/*/login')) {
                $space = $request->route('space') ?? 'admin';

                return redirect()->route('home')
                    ->with('login_space', $space)
                    ->with('login_error', 'Session expirée. Réactualisez la page (F5) puis reconnectez-vous.');
            }

            if ($request->is('espace/*/logout')) {
                return redirect()->route('home')
                    ->with('login_error', 'Session expirée. Veuillez vous reconnecter.');
            }

            return redirect()->back()
                ->withInput($request->except('_token', 'password'))
                ->with('login_error', 'Page expirée. Réactualisez la page puis réessayez.');
        });
    })->create();
