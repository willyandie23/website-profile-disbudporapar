<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DownloadController;
use App\Http\Controllers\API\GaleryController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\OrganizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:api');

Route::get('/organizations', [OrganizationController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/banner', [BannerController::class, 'index']);
Route::get('/galery', [GaleryController::class, 'index']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/downloads', [DownloadController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::post('/banner', [BannerController::class, 'store']);
    Route::get('/banner/{id}', [BannerController::class, 'show']);
    Route::put('/banner/{id}', [BannerController::class, 'update']);
    Route::delete('/banner/{id}', [BannerController::class, 'destroy']);

    Route::post('/organizations', [OrganizationController::class, 'store']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'show']);
    Route::put('/organizations/{id}', [OrganizationController::class, 'update']);
    Route::delete('/organizations/{id}', [OrganizationController::class, 'destroy']);

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    
    Route::post('/galery', [GaleryController::class, 'store']);
    Route::get('/galery/{id}', [GaleryController::class, 'show']);
    Route::put('/galery/{id}', [GaleryController::class, 'update']);
    Route::delete('/galery/{id}', [GaleryController::class, 'destroy']);
    
    Route::post('/news', [NewsController::class, 'store']);
    Route::get('/news/{id}', [NewsController::class, 'show']);
    Route::put('/news/{id}', [NewsController::class, 'update']);
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);
    
    Route::post('/downloads', [DownloadController::class, 'store']);
    Route::get('/downloads/{id}', [DownloadController::class, 'show']);
    Route::put('/downloads/{id}', [DownloadController::class, 'update']);
    Route::delete('/downloads/{id}', [DownloadController::class, 'destroy']);
    Route::post('/downloads/{id}/download', [DownloadController::class, 'download']);
});