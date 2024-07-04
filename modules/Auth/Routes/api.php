<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/admin/me', function (Request $request) {
    return $request->user('admin');
})->middleware('auth:admin');
