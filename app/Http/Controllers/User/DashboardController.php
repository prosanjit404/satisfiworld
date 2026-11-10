<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('user/Dashboard', [
            'account' => [
                'id' => $user?->getKey(),
                'name' => $user?->name,
                'email' => $user?->email,
                'avatar' => null,
                'membership' => null,
            ],
            'dashboard' => config('dashboard', []),
            'siteName' => (string) (gs('site_name') ?: config('app.name')), 
        ]);
    }
}
