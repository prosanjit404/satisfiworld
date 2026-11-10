<?php

namespace App\Http\Middleware;

use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserEmailVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user('web');
        $required = gs('email_verification_required') ?? 1;

        if ($user && $required && ! $user->hasVerifiedEmail()) {
            return to_route('user.verification.notice');
        }

        return $next($request);
    }
}
