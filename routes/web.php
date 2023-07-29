<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PrivacyController,
    ProfileController,
    TimelineController,
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



Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function() {
    Route::get('/', fn() => view('dashboard'))->name('dashboard');

    Route::group(['prefix' => 'timeline'], function() {
        Route::get('/', [ TimelineController::class, 'list' ])->name('list_timeline_entries');
        Route::post('/create', [ TimelineController::class, 'create' ])->name('post.timeline_entry');
    });
   
   
    Route::group(['prefix' => 'profile/{user}'], function() {
        Route::get('/', [ ProfileController::class, 'index' ])->name('profile');
        Route::group(['middleware' => 'can:update,user'], function() {
            Route::post('/personal', [ ProfileController::class, 'update' ])->name('post.update_personal_info');
            Route::post('/privacy', [ PrivacyController::class, 'update' ])->name('post.update_privacy');
            Route::post('/password', [ UserController::class, 'update' ])->name('post.update_user');
        });
    });

    Route::group(['prefix' => '{user}/books'], function() {
        Route::get('/', fn() => view('my-books'))->name('my_books');  
    });
});

require __DIR__.'/auth.php';
