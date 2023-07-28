<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PrivacyController,
    ProfileController,
    UserController
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
   
    Route::prefix('profile/{user}')->group(function() {
        Route::get('/', [ ProfileController::class, 'index' ])->name('profile');
        Route::post('/personal', [ ProfileController::class, 'update' ])->name('post.update_personal_info')->middleware('can:update,user');
        Route::post('/privacy', [ PrivacyController::class, 'update' ])->name('post.update_privacy')->middleware('can:update,user');
        Route::post('/password', [ UserController::class, 'update' ])->name('post.update_user')->middleware('can:update,user');
    });
});

require __DIR__.'/auth.php';
