<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/video/upload', function (Request $request) {
    $res = $request->file('file')->store();

    return response()->json([
        'res' => $res,
    ]);
});

Route::get('/video', function (Request $request) {
    $pathToFile = storage_path('app/WoVz9D9vIA0qzpah2vpUZFQdrcEsCHHT9uKG352k.mp4'); // specify the path to your video file
    ini_set('memory_limit', '1G');

    $response = new \Symfony\Component\HttpFoundation\StreamedResponse();

    $response->setCallback(function () use ($pathToFile) {
        $stream = fopen($pathToFile, 'rb');
        while (! feof($stream)) {
            echo fread($stream, 1024 * 8);
            ob_flush();
            flush();
        }
        fclose($stream);
    });

    $response->headers->set('Content-Type', 'video/mp4');
    $response->headers->set('Content-Length', filesize($pathToFile));
    $response->headers->set('Accept-Ranges', 'bytes');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('X-Accel-Buffering', 'no');

    return $response;
});
