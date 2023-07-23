<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    NewPasswordController,
    PasswordController,
    PasswordResetLinkController,
    RegisteredUserController
};

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('register', RegisteredUserController::class)->name('post.create_account');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('post.login');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('post.logout');
});
