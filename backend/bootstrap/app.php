<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /**
         * Enable Sanctum's SPA (stateful) auth so our React app on :3000
         * can authenticate via cookies (XSRF-TOKEN + session).
         */
        $middleware->statefulApi();

        // You can add global or group middleware here later if needed.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
