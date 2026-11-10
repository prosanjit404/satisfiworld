<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::controller('SiteController')->group(function () {
    
    Route::get('maintenance', 'maintenance')->name('maintenance');

});



