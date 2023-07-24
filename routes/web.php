<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PrivacyController,
    ProfileController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn () => view('welcome'))->middleware('guest')->name('login');

Route::prefix('dashboard')->middleware('auth')->group(function() {
    Route::get('/', fn () => view('dashboard'))->name('dashboard');
   
    Route::prefix('profile')->group(function() {
        Route::get('/', fn () => view('profile'))->name('profile');
        Route::post('/personal', [ ProfileController::class, 'update' ])->name('post.update_personal_info');
        Route::post('/privacy', [ PrivacyController::class, 'update' ])->name('post.update_privacy');
    });
});

require __DIR__.'/auth.php';
