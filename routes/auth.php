<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->as('auth.')->group(function () {
    Route::get('/login', 'create')->name('login.create')->middleware('guest');
    Route::post('/login', 'store')->name('login.store')->middleware('guest');
    Route::delete('/logout', 'destroy')->name('logout');
});
