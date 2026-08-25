<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Admin\AuthController;

// Language Toggle
Route::get('/lang/{locale}', [LocaleController::class, 'switchLang'])->name('lang.switch');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/program', [ProgramController::class, 'index'])->name('public.programs.index');
Route::get('/program/{code}', [ProgramController::class, 'show'])->name('public.programs.show');

Route::get('/cerita-dampak', [StoryController::class, 'index'])->name('public.stories.index');
Route::get('/cerita-dampak/{slug}', [StoryController::class, 'show'])->name('public.stories.show');

Route::get('/relawan', [VolunteerController::class, 'index'])->name('public.volunteer.index');
Route::post('/relawan/register', [VolunteerController::class, 'store'])->name('public.volunteer.store');

Route::get('/desa-binaan', [PageController::class, 'desaBinaan'])->name('public.pages.desabinaan');
Route::get('/desa-binaan/{slug}', [PageController::class, 'showVillage'])->name('public.pages.village.show');
Route::get('/mitra', [PageController::class, 'mitra'])->name('public.pages.mitra');
Route::get('/tentang-kami', [PageController::class, 'tentangKami'])->name('public.pages.tentangkami');
Route::get('/galeri', [PageController::class, 'galeri'])->name('public.pages.galeri');

// Public Donation
Route::get('/donasi', function () {
    return view('public.donasi.index');
})->name('public.donasi');


// Admin Guest / Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::get('admin/forgot-password', [AuthController::class, 'showForgotPassword'])->name('admin.password.request');
    Route::post('admin/forgot-password', [AuthController::class, 'sendResetLink'])->name('admin.password.email');
});

// Admin Protected Routes
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Both Admin and Contributor can manage Stories (Articles)
    Route::post('stories/upload-image', [\App\Http\Controllers\Admin\StoryController::class, 'uploadImage'])->name('stories.upload_image');
    Route::get('stories/export', [\App\Http\Controllers\Admin\StoryController::class, 'export'])->name('stories.export');
    Route::get('stories/template', [\App\Http\Controllers\Admin\StoryController::class, 'downloadTemplate'])->name('stories.template');
    Route::post('stories/import', [\App\Http\Controllers\Admin\StoryController::class, 'import'])->name('stories.import');
    Route::resource('stories', \App\Http\Controllers\Admin\StoryController::class);

    // Only Admin can manage other modules
    Route::middleware('only.admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('programs', \App\Http\Controllers\Admin\ProgramController::class);
        Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);
        Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class);
        Route::resource('villages', \App\Http\Controllers\Admin\VillageController::class);
        
        Route::resource('hero-images', \App\Http\Controllers\Admin\HeroImageController::class);
        Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class)->only(['index', 'update']);
        Route::resource('statistics', \App\Http\Controllers\Admin\StatisticController::class)->only(['index', 'edit', 'update']);
        Route::resource('social-links', \App\Http\Controllers\Admin\SocialLinkController::class);
        
        // Volunteers Admin Panel
        Route::get('volunteers', [\App\Http\Controllers\Admin\VolunteerController::class, 'index'])->name('volunteers.index');
        Route::get('volunteers/create', [\App\Http\Controllers\Admin\VolunteerController::class, 'create'])->name('volunteers.create');
        Route::post('volunteers', [\App\Http\Controllers\Admin\VolunteerController::class, 'store'])->name('volunteers.store');
        Route::get('volunteers/{id}/edit', [\App\Http\Controllers\Admin\VolunteerController::class, 'edit'])->name('volunteers.edit');
        Route::put('volunteers/{id}', [\App\Http\Controllers\Admin\VolunteerController::class, 'update'])->name('volunteers.update');
        Route::delete('volunteers/{id}', [\App\Http\Controllers\Admin\VolunteerController::class, 'destroy'])->name('volunteers.destroy');
    });
});
