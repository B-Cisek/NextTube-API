<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\LoginUserController;
use Modules\Auth\Http\Controllers\LogoutUserController;
use Modules\Auth\Http\Controllers\SignupUserController;

Route::post('/signup', SignupUserController::class)
    ->middleware('guest')
    ->name('signup');

Route::post('/login', LoginUserController::class)
    ->middleware('guest')
    ->name('login');

Route::post('/logout', LogoutUserController::class)
    ->middleware('auth')
    ->name('logout');
