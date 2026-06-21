<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PricingController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/pricing', PricingController::class)->name('pricing');
Route::view('/live-classes', 'live-classes')->name('live-classes');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('admin')
        ->middleware('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', AdminDashboardController::class)->name('dashboard');

            // Settings
            Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings');
            Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

            // Categories
            Route::resource('categories', AdminCategoryController::class);

            // Courses
            Route::resource('courses', AdminCourseController::class);

            // Course PDFs
            Route::delete('courses/{course}/files/{file}', [AdminCourseController::class, 'destroyFile'])
                ->name('courses.files.destroy');

            // Course Videos
            Route::post('courses/{course}/videos', [AdminCourseController::class, 'storeVideo'])
                ->name('courses.videos.store');
            Route::put('courses/{course}/videos/{video}', [AdminCourseController::class, 'updateVideo'])
                ->name('courses.videos.update');
            Route::delete('courses/{course}/videos/{video}', [AdminCourseController::class, 'destroyVideo'])
                ->name('courses.videos.destroy');
        });
});
