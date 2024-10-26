<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        using: function (Router $router) {
            $router->middleware('throttle:api')
                ->prefix('api/v1')->group(function () use ($router) {
                    $router->namespace('App\Http\Controllers\Api')
                        ->group(base_path('routes/v1/api.php'));
                });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->alias([
        //     // 'isCustomer' => ::class,
        //     'isAdmin' => IsAdmin::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
