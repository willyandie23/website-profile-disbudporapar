<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\FieldController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\GaleryController;
use App\Http\Controllers\API\DownloadController;
use App\Http\Controllers\API\IdentityController;
use App\Http\Controllers\Frontend\MainController;
use App\Http\Controllers\Backend\AppLogController;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\DownloadController as FrontendDownloadController;
use App\Http\Controllers\Frontend\FieldController as FrontendFieldController;
use App\Http\Controllers\Frontend\GaleryController as FrontendGaleryController;
use App\Http\Controllers\Frontend\GreetingController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Controllers\Frontend\OrganizationController as FrontendOrganizationController;

Route::get('/', [MainController::class, 'index'])->name('home.index');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/berita', [FrontendNewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita}', [FrontendNewsController::class, 'show'])->name('berita.show');
Route::get('/unduhan', [FrontendDownloadController::class, 'index'])->name('unduhan.index');
Route::get('/galeri', [FrontendGaleryController::class, 'index'])->name('galeri.index');
Route::get('/bidang/{bidang}', [FrontendFieldController::class, 'show'])->name('bidang.show');
Route::get('/sambutan', [GreetingController::class, 'index'])->name('sambutan.index');
Route::get('/organisasi', [FrontendOrganizationController::class, 'index'])->name('organisasi.index');


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
    
    Route::get('/organizational-structure/fields', [FieldController::class, 'fieldShow'])->name('field.index');
    Route::get('/organizational-structure/fields/create', [FieldController::class, 'create'])->name('field.create');
    Route::get('/organizational-structure/fields/{field}/edit', [FieldController::class, 'edit'])->name('field.edit');
    Route::post('/organizational-structure/fields', [FieldController::class, 'store'])->name('field.store');
    
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

    Route::get('/app-logs', [AppLogController::class, 'index'])->name('logs.index');
    Route::get('/app-logs/{id}', [AppLogController::class, 'show'])->name('logs.show');

    Route::get('/identity', [IdentityController::class, 'identityShow'])->name('identity.index');
    Route::post('/identity', [IdentityController::class, 'store'])->name('identity.store');
});

require __DIR__.'/auth.php';