<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/settings', fn () => new JsonResponse([
        'chunkSize' => 52428800, // 50MB
    ]));
});
