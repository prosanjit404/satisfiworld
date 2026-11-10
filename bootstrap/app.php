<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        using: function () {
            Route::namespace('App\Http\Controllers')->group(function () {
                Route::prefix('api')->middleware(['api', 'maintenance'])->group(base_path('routes/api.php'));
                Route::prefix('royeladmin')->middleware(['web'])->namespace('Admin')->name('admin.')->group(base_path('routes/admin.php'));
                Route::prefix('user')->middleware(['web', 'maintenance'])->group(base_path('routes/user.php'));
                Route::middleware(['web', 'maintenance'])->group(base_path('routes/web.php'));
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);


        $middleware->alias([

            // Core
            'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'can'              => \Illuminate\Auth\Middleware\Authorize::class,
            'auth'             => \App\Http\Middleware\Authenticate::class,
            'guest'            => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed'           => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,

            // Custom Project Middleware
            'admin'            => \App\Http\Middleware\RedirectIfNotAdmin::class,
            'admin.guest'      => \App\Http\Middleware\RedirectIfAdmin::class,
            'maintenance'      => \App\Http\Middleware\MaintenanceMode::class,

            'delete.status'         => \App\Http\Middleware\DeleteStatusMiddleware::class,
            'user.verified' => \App\Http\Middleware\EnsureUserEmailVerified::class,
        ]);



    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
