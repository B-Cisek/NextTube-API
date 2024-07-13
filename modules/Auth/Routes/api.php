<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\EmailVerificationNotificationController;
use Modules\Auth\Http\Controllers\NewPasswordController;
use Modules\Auth\Http\Controllers\PasswordResetLinkController;
use Modules\Auth\Http\Controllers\VerifyEmailController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', fn (Request $request) => $request->user());
    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification', EmailVerificationNotificationController::class)
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/me', fn (Request $request) => $request->user('admin'));
});


Route::middleware(['guest'])->group(function () {
    Route::post('/forgot-password', PasswordResetLinkController::class)->name('password.email');
    Route::post('/reset-password', NewPasswordController::class)->name('password.update');
});
