<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function maintenance()
    {
        if ((int) gs('maintenance_mode') === 0) {
            return to_route('home');
        }

        return inertia('Maintenance', [
            'siteName' => gs('site_name') ?? config('app.name'),
        ]);
    }
}
