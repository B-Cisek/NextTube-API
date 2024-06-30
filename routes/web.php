<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Response::json([
        'AppName' => config('app.name'),
        'Laravel' => app()->version(),
        'PHP' => PHP_VERSION,
    ]);
});
