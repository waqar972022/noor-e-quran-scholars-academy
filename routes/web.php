<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideosController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/videos', VideosController::class)->name('videos.index');
Route::get('/books', BooksController::class)->name('books.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/pricing', PricingController::class)->name('pricing');
Route::view('/live-classes', 'live-classes')->name('live-classes');
Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->middleware('throttle:5,1')->name('login.attempt');
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('register.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard',        DashboardController::class)->name('dashboard');

    // User area
    Route::get('/my-learning',      [DashboardController::class, 'learning'])->name('user.learning');
    Route::get('/subscription',     [DashboardController::class, 'subscription'])->name('user.subscription');
    Route::get('/payment-history',  [DashboardController::class, 'payments'])->name('user.payments');
    Route::get('/notifications',            [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all',  [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

    // Profile
    Route::get('/profile',          [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Checkout
    Route::get('/checkout/{plan}',  [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{plan}', [CheckoutController::class, 'store'])->name('checkout.store');

    // Subscription-gated content
    Route::get('/courses/{slug}/videos/{video}',          [ContentController::class, 'video'])->name('content.video');
    Route::get('/courses/{slug}/files/{file}',            [ContentController::class, 'pdf'])->name('content.pdf');
    Route::get('/courses/{slug}/files/{file}/stream',     [ContentController::class, 'pdfStream'])->name('content.pdf.stream');
    Route::get('/courses/{slug}/files/{file}/download',   [ContentController::class, 'pdfDownload'])->name('content.pdf.download');
    Route::post('/courses/{slug}/videos/{video}/complete',[ContentController::class, 'markComplete'])->name('content.video.complete');


    Route::prefix('admin')
        ->middleware('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', AdminDashboardController::class)->name('dashboard');

            // Payment requests
            Route::get('payment-requests', [AdminPaymentController::class, 'index'])->name('payments.index');
            Route::get('payment-requests/{paymentRequest}', [AdminPaymentController::class, 'show'])->name('payments.show');
            Route::get('payment-requests/{paymentRequest}/screenshot', [AdminPaymentController::class, 'screenshot'])->name('payments.screenshot');
            Route::post('payment-requests/{paymentRequest}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
            Route::post('payment-requests/{paymentRequest}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

            // Settings
            Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings');
            Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

            // Categories
            Route::resource('categories', AdminCategoryController::class);

            // Courses
            Route::resource('courses', AdminCourseController::class);

            // Users
            Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
            Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
            Route::post('users/{user}/password', [AdminUserController::class, 'setPassword'])->name('users.password');
            Route::post('users/{user}/activate', [AdminUserController::class, 'activateSubscription'])->name('users.activate');
            Route::post('users/{user}/revoke', [AdminUserController::class, 'revokeSubscription'])->name('users.revoke');

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
