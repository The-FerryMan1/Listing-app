<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;





Route::middleware('guest')->group(function () {
    //<--------------------------Register route---------------------------> 
    Route::get('/register', function () {
        return inertia('Register', );
    })->name('register');
    Route::post('/register', [AuthController::class, 'Register']);

    //<--------------------------Login route---------------------------> 

    Route::get('/login', function () {
        return inertia('Login', [
            'status' => session('status'),
        ]);
    })->name('login');
    Route::post('/login', [AuthController::class, 'Login']);

    //<--------------------------Reset password route---------------------------> 

    Route::get('/forgot-password', [ResetPasswordController::class, 'requestPass'])->name('password.request');

    Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPass'])->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'resetHandler'])->name('password.update');

});

Route::get('/', [ListingController::class, 'index'])->name('home');
Route::resource('/listings', ListingController::class)->except('index');


// admin route

Route::middleware(['auth','verified', Admin::class])->controller(AdminController::class)->group(function(){
    Route::get('/admin', 'index')->name('admin.index');
    Route::get('/users/{user}', 'show')->name('user.show');
    Route::put('/admin/{user}/role', 'role')->name('admin.role');
    Route::put('/listing/{listing}/approve', 'approve')->name('admin.approve');
});

// auth route
require __DIR__ . '/auth.php';