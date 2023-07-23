<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
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
    Route::get('/profile', fn () => view('profile'))->name('profile');
    Route::post('/profile/personal', [ UserController::class, 'update' ])->name('post.update_personal_info');
});

require __DIR__.'/auth.php';
