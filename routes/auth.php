<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfirmPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    //<--------------------------Dashboard route---------------------------> 
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    //<--------------------------profile route---------------------------> 
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware('password.confirm')->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'updateInfo'])->name('profile.update');

    //<--------------------------Change password---------------------------> 
    Route::put('/profile', [ProfileController::class, 'changePassword'])->name('ProfileUpdate.password');

    //<--------------------------Delete account password---------------------------> 
    Route::delete('/profile', [ProfileController::class, 'destroyAccount'])->name('account.destroy');

    //<--------------------------Confirm pass route---------------------------> 
    Route::get('/confirm-password', [ConfirmPasswordController::class, 'index'])->name('password.confirm');

    Route::post('/confirm-password', [ConfirmPasswordController::class, 'confirmPasswordHandler'])->middleware(['throttle:6,1']);

    //<--------------------------Logout route---------------------------> 
    Route::post('/logout', [AuthController::class, 'Logout'])->name('logout');

    //<--------------------------Email verification route---------------------------> 
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'handler'])->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
});