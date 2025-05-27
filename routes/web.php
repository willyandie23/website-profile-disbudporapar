<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:admin|superadmin')->group(function() {
    Route::get('/banner', [BannerController::class, 'bannerShow'])->name('banner.index');
    Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
    Route::get('/banner/{slider}/edit', [BannerController::class, 'edit'])->name('banner.edit');
    Route::post('/banner', [BannerController::class, 'store'])->name('banner.store');
});

require __DIR__.'/auth.php';
