<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return inertia('user/auth/Login');
    }


    public function login(Request $request)
    {
        // 1. Validate credentials
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Attempt authentication
        if (!Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors([
                    'email' => 'Invalid email or password.',
                ])
                ->onlyInput('email');
        }

        // 3. Regenerate session for security
        $request->session()->regenerate();

        toast('You have been logged in successfully.', 'success', 'success');
        return redirect()->intended(route('user.dashboard'));
    }

    public function logout()
    {
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        toast('You have been logged out successfully.', 'success', 'success');
        return redirect()->route('user.login');
    }
}
