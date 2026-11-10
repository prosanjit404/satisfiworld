<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return inertia('user/auth/Register');
    }

    public function register(Request $request)
    {
        // Registration logic here
    }
}
