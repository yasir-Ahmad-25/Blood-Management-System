<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'custom.auth' => App\Http\Middleware\RedirectIfNotAuthenticated::class,
            'custom.guest' => App\Http\Middleware\RedirectIfAuthenticated::class,

            'custom.hospital_auth' => App\Http\Middleware\RedirectIfHospitalNotAuthenticated::class,
            'custom.hospital_guest' => App\Http\Middleware\RedirectIfHospitalAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
