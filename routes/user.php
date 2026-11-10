<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->middleware('guest:web')->group(function () {
    
    Route::controller('LoginController')->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login')->middleware('throttle:10,1')->name('login.submit');
        Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('throttle:5,1')->name('register.submit');
    });

});

Route::middleware('auth', 'delete.status', 'user.verified')->name('user.')->group(function () {
    Route::namespace('User')->group(function () {

        Route::controller('DashboardController')->group(function () {
            Route::get('dashboard', 'index')->name('dashboard');
        });

    });
});