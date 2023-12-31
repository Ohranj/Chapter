<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CommentController,
    CountryController,
    ExploreCommunityController,
    FollowUserController,
    InboxController,
    PrivacyController,
    ProfileController,
    TagController,
    TimelineController,
    TrendingController,
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
    Route::get('/', [ UserController::class, 'index' ])->name('dashboard');
    Route::get('/tags', TagController::class)->name('list_tags');
    Route::get('/countries', CountryController::class)->name('list_countries');

    Route::group(['prefix' => 'timeline'], function() {
        Route::get('/', [ TimelineController::class, 'list' ])->name('list_timeline_entries');
        Route::post('/create', [ TimelineController::class, 'create' ])->name('post.timeline_entry');
        Route::put('/like/{timeline}', [ TimelineController::class, 'toggleLike' ])->name('put.like');
        Route::delete('/{timeline}', [ TimelineController::class, 'delete' ])->name('delete.timeline_entry');
    });
   
    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', [ ProfileController::class, 'index' ])->name('profile');
        Route::post('/personal', [ ProfileController::class, 'update' ])->name('post.update_personal_info');
        Route::post('/privacy', [ PrivacyController::class, 'update' ])->name('post.update_privacy');
        Route::post('/password', [ UserController::class, 'update' ])->name('post.update_user');
        
    });

    Route::group(['prefix' => 'books'], function() {
        Route::get('/', fn() => view('my-books'))->name('my_books');  
    });

    Route::group(['prefix' => 'stats'], function() {
        Route::get('/', fn() => view('my-stats'))->name('my_stats');  
    });

    Route::group(['prefix' => 'inbox'], function() {
        Route::get('/', [InboxController::class, 'index'])->name('inbox');
        Route::get('/list', [ InboxController::class, 'list' ])->name('list_inbox');
        Route::put('{comment}/read/toggle', [ InboxController::class, 'toggleIsRead' ])->name('toggle_read_state');
    });
});

Route::group(['prefix' => 'explore', 'middleware' => ['auth']], function() {
    Route::group(['prefix' => 'community'], function() {
        Route::get('/', ExploreCommunityController::class)->name('explore_community');  
        Route::get('/nabus', [ UserController::class, 'list' ])->name('list_nabus');
    });
    
    Route::group(['prefix' => 'books'], function() {
        Route::get('/', fn() => view('explore-books'))->name('explore_books');  
    });
});

Route::post('followers/update', [ FollowUserController::class, 'update' ])->name('post.follower');
Route::post('/comments', [ CommentController::class, 'create' ])->name('post.comment');

Route::get('/trending', TrendingController::class);


require __DIR__.'/auth.php';
