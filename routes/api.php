<?php

use App\Http\Controllers\API\BannerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:api');

Route::get('/banner', [BannerController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::post('/banner', [BannerController::class, 'store']);
    Route::get('/banner/{id}', [BannerController::class, 'show']);
    Route::put('/banner/{id}', [BannerController::class, 'update']);
    Route::delete('/banner/{id}', [BannerController::class, 'destroy']);
});