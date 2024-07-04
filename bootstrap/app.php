<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();

        $middleware->prependToGroup('auth:admin', [
            \Modules\Auth\Http\Middleware\AdminAuth::class,
        ]);

        $middleware->prepend([
            \App\Http\Middleware\EnsureJsonResponse::class,
        ]);
    })
    ->withEvents(discover: [
        __DIR__.'/../modules/Auth/Listeners',
        __DIR__.'/../modules/Auth/Events',
    ])
    ->withExceptions(function (Exceptions $exceptions) {})->create();
