<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\LikeController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Test PHP settings
Route::get('/php-settings', function() {
    return [
        'PHP Version' => phpversion(),
        'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
        'max_input_time' => ini_get('max_input_time'),
        'max_file_uploads' => ini_get('max_file_uploads'),
        'Loaded php.ini' => php_ini_loaded_file(),
        'Additional ini files' => php_ini_scanned_files(),
        'Disk Free Space' => disk_free_space('/'),
        'Disk Total Space' => disk_total_space('/'),
    ];
});

// Test file upload with detailed logging
Route::post('/test-upload-handler', function(Request $request) {
    \Log::info('Test upload started', ['request' => $request->all()]);
    
    // Log all files in the request
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        \Log::info('File details', [
            'original_name' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'error' => $file->getError(),
            'is_valid' => $file->isValid(),
        ]);
        
        try {
            $path = $file->store('test-uploads', 'public');
            \Log::info('File stored successfully', ['path' => $path]);
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::disk('public')->url($path)
            ]);
        } catch (\Exception $e) {
            \Log::error('File upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    } else {
        \Log::warning('No file in request', ['files' => $_FILES]);
        return response()->json([
            'success' => false,
            'error' => 'No file uploaded'
        ], 400);
    }
})->name('test.upload.handler');

// Test route for PHP upload settings
// Simple test upload form
Route::get('/test-upload', function() {
    return view('test-upload');
});

// Handle test upload
Route::post('/test-upload', function(Request $request) {
    $request->validate([
        'file' => 'required|file|max:2048', // 2MB max
    ]);

    $path = $request->file('file')->store('test-uploads', 'public');
    
    return back()->with('success', 'File uploaded successfully: ' . $path);
})->name('test.upload');

// Test upload settings
Route::get('/test-upload-settings', function() {
    return [
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
        'max_input_time' => ini_get('max_input_time'),
        'max_file_uploads' => ini_get('max_file_uploads'),
        'loaded_php_ini' => php_ini_loaded_file(),
        'additional_inis' => php_ini_scanned_files(),
    ];
});

// Test route for debugging storage
Route::get('/test-storage', function () {
    $exists = Storage::disk('public')->exists('foods/W7YvqptcZ2g3UTrH8muvCZvB4ls12wG5ELwXhYM0.jpg');
    $url = Storage::disk('public')->url('foods/W7YvqptcZ2g3UTrH8muvCZvB4ls12wG5ELwXhYM0.jpg');
    $files = Storage::disk('public')->allFiles('foods');
    
    return [
        'exists' => $exists,
        'url' => $url,
        'files' => $files,
        'public_path' => public_path(),
        'storage_path' => storage_path(),
        'app_url' => config('app.url'),
    ];
});

// Landing Page
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('loginseller', [LoginController::class, 'showSellerLoginForm'])->name('seller.login');
    Route::post('loginseller', [LoginController::class, 'sellerLogin'])->name('seller.login.submit');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register-seller', [RegisterController::class, 'showSellerRegistrationForm'])->name('seller.register');
    Route::get('register-showcase', function () {
        return view('auth.register-showcase');
    })->name('register.showcase');
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Public Routes
Route::get('/lainnya', [FoodController::class, 'publicMenu'])->name('menu.public');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Courier2 Route
    Route::get('/courier2', [DashboardController::class, 'courier2'])->name('courier2');
    
    // Get ready orders count for notification
    Route::get('/orders/ready/count', [DashboardController::class, 'getReadyOrdersCount'])
        ->middleware('role:mahasiswa')
        ->name('orders.ready.count');
    
    // Food routes for mahasiswa
    Route::get('/foods/create2', [FoodController::class, 'create2'])->name('foods.create2');
    Route::post('/foods/store2', [FoodController::class, 'store2'])->name('foods.store2');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Profile Photo Routes
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.update.photo');
    Route::patch('/profile/cover-photo', [ProfileController::class, 'updateCoverPhoto'])
        ->name('profile.update.cover');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])
        ->name('profile.destroy.photo');
        
    // Like/Unlike Food
    Route::post('/foods/{food}/like', [LikeController::class, 'toggleLike'])
        ->name('foods.like');

    // Food Items (Seller and Mahasiswa)
    Route::middleware('role:seller|mahasiswa')->group(function () {
        // Standard resource routes (including create)
        Route::resource('foods', FoodController::class);
        
        // Custom create2 and store2 routes for mahasiswa
        Route::get('foods/create2', [FoodController::class, 'create2'])->name('foods.create2');
        Route::post('foods/store2', [FoodController::class, 'store2'])->name('foods.store2');
    });
    
    // Food management routes (Seller and Mahasiswa)
    Route::middleware('role:seller|mahasiswa')->group(function () {
        Route::patch('foods/{food}/toggle', [FoodController::class, 'toggleAvailability'])->name('foods.toggle');
        Route::post('foods/{food}/increment-delivery', [FoodController::class, 'incrementDeliveryCount'])->name('foods.increment-delivery');
    });

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/mahasiswa', [OrderController::class, 'mahasiswa'])->name('orders.mahasiswa');
        Route::get('/create/{food?}', [OrderController::class, 'create'])->name('orders.create');
        Route::get('/create2/{food?}', [OrderController::class, 'create2'])->name('orders.create2');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/history', [OrderController::class, 'history'])->name('orders.history');
        Route::get('/{order}/track', [OrderController::class, 'track'])->name('orders.track');
        Route::get('/{order}/status', [OrderController::class, 'status'])->name('orders.status');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::patch('/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/{order}/show2', [OrderController::class, 'show2'])->name('orders.show2');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
        
        // Rating routes
        Route::get('/{order}/rate', [OrderController::class, 'showRatingPage'])->name('orders.rate');
        Route::post('/{order}/submit-rating', [OrderController::class, 'submitRating'])->name('orders.submitRating');
    });

    Route::get('/refresh-foods', [OrderController::class, 'refreshFoods'])->name('foods.refresh');

    // Reviews
    Route::get('reviews/create/{order}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews/{order}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::resource('reviews', ReviewController::class)->only(['update']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Showcases
    Route::get('/showcases', [ShowcaseController::class, 'index'])->name('showcases.index');

    // Rating Page
    Route::get('/rating/{order}', [RatingController::class, 'show'])->name('rating.page');

    // Rating routes
    Route::get('/orders/{order}/rate', [App\Http\Controllers\RatingController::class, 'show'])->name('orders.rate.show');
    Route::post('/api/orders/{order}/rate', [App\Http\Controllers\RatingController::class, 'submitRating'])->name('orders.rate.submit');
    Route::get('/api/notifications', [App\Http\Controllers\RatingController::class, 'getNotifications'])->name('notifications.get');
    Route::post('/api/notifications/{id}/read', [App\Http\Controllers\RatingController::class, 'markAsRead'])->name('notifications.markAsRead');
});

Route::get('/event', function () {
    return view('event');
})->name('event');
