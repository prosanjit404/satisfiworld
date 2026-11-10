<?php

namespace App\Http\Middleware;

use Closure;

class MaintenanceMode
{
    public function handle($request, Closure $next)
    {
        if ($request->routeIs('maintenance')) {
            return $next($request);
        }

        if (gs('maintenance_mode') == 1) {
            if ($request->is('api/*')) {
                $notify[] = 'Our application is currently in maintenance mode';

                return response()->json([
                    'remark' => 'maintenance_mode',
                    'status' => 'error',
                    'message' => ['error' => $notify]
                ], 503);
            } else {
                return to_route('maintenance');
            }
        }

        return $next($request);
    }
}
