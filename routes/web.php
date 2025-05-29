<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DownloadController;
use App\Http\Controllers\API\GaleryController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\OrganizationController;
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

    Route::get('/organizational-structure/organizations', [OrganizationController::class, 'organizationShow'])->name('organizations.index');
    Route::get('/organizational-structure/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::get('/organizational-structure/organizations/{organizations}/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::post('/organizational-structure/organizations', [OrganizationController::class, 'store'])->name('organizations.store');

    Route::get('/organizational-structure/category', [CategoryController::class, 'organizationCategoriesShow'])->name('category.index');
    Route::get('/organizational-structure/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/organizational-structure/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/organizational-structure/category', [CategoryController::class, 'store'])->name('category.store');
    
    Route::get('/galery', [GaleryController::class, 'galleryShow'])->name('gallery.index');
    Route::get('/galery/create', [GaleryController::class, 'create'])->name('gallery.create');
    Route::get('/galery/{galery}/edit', [GaleryController::class, 'edit'])->name('gallery.edit');
    Route::post('/galery', [GaleryController::class, 'store'])->name('gallery.store');
    
    Route::get('/news', [NewsController::class, 'newsShow'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');

    Route::get('/downloads', [DownloadController::class, 'downloadShow'])->name('download.index');
    Route::get('/downloads/create', [DownloadController::class, 'create'])->name('download.create');
    Route::get('/downloads/{downloads}/edit', [DownloadController::class, 'edit'])->name('download.edit');
    Route::post('/downloads', [DownloadController::class, 'store'])->name('download.store');
    Route::post('/downloads/{downloads}/download', [DownloadController::class, 'download'])->name('downloads.download');
});

require __DIR__.'/auth.php';