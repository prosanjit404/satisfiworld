<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\ExceptionResponse;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->configureDefaults();

        Inertia::handleExceptionsUsing(function (ExceptionResponse $response) {
            $request = $response->request;
            $status = $response->statusCode();

            if ($request->is('api/*') || $request->is('royeladmin/*') || ($request->expectsJson() && !$request->header('X-Inertia'))) {
                return null;
            }

            if (config('app.debug')) {
                return null;
            }

            if (!in_array($status, [403, 404, 405, 429, 500, 503], true)) {
                return null;
            }

            $siteName = config('app.name');

            if ($status < 500) {
                try {
                    $siteName = gs('site_name') ?: $siteName;
                } catch (\Throwable) {
                }
            }

            return $response->render('ErrorPage', [
                'status' => $status,
                'siteName' => $siteName,
            ])->rootView('app');
        });
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);
        DB::prohibitDestructiveCommands(app()->isProduction());
        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)->mixedCase()->letters()->numbers()->symbols()->uncompromised()
            : null);
    }
}
