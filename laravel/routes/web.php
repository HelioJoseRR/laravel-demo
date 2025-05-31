<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReviewController; // Importa o controlador de reviews
use App\Http\Controllers\HomeController; // Importa o controlador de home
use App\Http\Controllers\SearchController; // Importa o controlador de busca

Route::redirect('/', '/users');

Route::get('/', [HomeController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/register', [UserController::class, 'register']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/profile/{id}', [UserController::class, 'profile']);
Route::get('/login', [UserController::class, 'login']);
Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout']);

// Albums routes
Route::get('/albums', [AlbumController::class, 'index']);
Route::get('/albums/view/{id}', [AlbumController::class, 'show']);

// Songs routes
Route::get('/songs', [SongController::class, 'index']);

// Song admin routes
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/songs/create', [SongController::class,'create']);
    Route::post('/songs',        [SongController::class,'store']);
    Route::get('/songs/{id}/edit', [SongController::class,'edit']);
    Route::post('/songs/{id}',   [SongController::class,'update']);
    Route::post('/songs/delete/{id}', [SongController::class,'destroy']);
});

// Playlists routes
Route::get('/playlists', [PlaylistController::class, 'index']);
Route::get('/playlists/create', [PlaylistController::class, 'create']);
Route::post('/playlists', [PlaylistController::class, 'store']);
Route::get('/playlists/view/{id}', [PlaylistController::class, 'show']);
Route::post('/playlists/add-song', [PlaylistController::class, 'addSong']);
Route::get('/playlists/edit/{id}', [PlaylistController::class, 'edit']);
Route::post('/playlists/edit/{id}', [PlaylistController::class, 'update']);
Route::post('/playlists/delete/{id}', [PlaylistController::class, 'delete']);

// Events routes
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/create', [EventController::class, 'create']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events/view/{id}', [EventController::class, 'show']);
Route::get('/events/edit/{id}', [EventController::class, 'edit']);
Route::post('/events/edit/{id}', [EventController::class, 'update']);
Route::post('/events/delete/{id}', [EventController::class, 'delete']);

// Forum routes
Route::get('/forum', [ForumController::class, 'index']);
Route::get('/forum/topic/{id}', [ForumController::class, 'show']);
Route::post('/forum/topic', [ForumController::class, 'storeTopic']);
Route::post('/forum/post', [ForumController::class, 'storePost']);

// Profile routes
Route::get('/profile/{id}', [ProfileController::class, 'show']);
Route::get('/profile/edit/{id}', [ProfileController::class, 'edit']);
Route::post('/profile/edit/{id}', [ProfileController::class, 'update']);

// Reviews listing route
Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index']);

// Reviews routes
Route::get('/reviews/create', [ReviewController::class, 'create'])->middleware('auth');
Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth');

// Search route
Route::get('/search', [SearchController::class, 'search'])->name('search');
