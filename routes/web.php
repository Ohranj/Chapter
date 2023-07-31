<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CountryController,
    PrivacyController,
    ProfileController,
    TagController,
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
    Route::get('/tags', TagController::class)->name('list_tags');
    Route::get('/countries', CountryController::class)->name('list_countries');

    Route::group(['prefix' => 'timeline'], function() {
        Route::get('/', [ TimelineController::class, 'list' ])->name('list_timeline_entries');
        Route::post('/create', [ TimelineController::class, 'create' ])->name('post.timeline_entry');
    });
   
    Route::group(['prefix' => 'profile/{user}'], function() {
        Route::get('/', fn() => view('profile'))->name('profile');
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

Route::group(['prefix' => 'explore', 'middleware' => ['auth']], function() {
    Route::group(['prefix' => 'community'], function() {
        Route::get('/', fn() => view('explore-community'))->name('explore_community');  
        Route::get('/nabus', [ UserController::class, 'list' ])->name('list_nabus');
    });
    
    Route::group(['prefix' => 'books'], function() {
        Route::get('/', fn() => view('explore-books'))->name('explore_books');  
    });
});


require __DIR__.'/auth.php';
