<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::redirect('/', '/postShow');

//Posts starts

Route::get('/postShow', [PostController::class, 'postShow'])->name('postShow');

Route::get('/postDetail/{post}', [PostController::class, 'postDetail'])->name('postDetail');
Route::post('/postDetail/{post}/comment', [PostController::class, 'addComment'])->name('addComment');

Route::get('/postCreate', [PostController::class, 'create'])->name('postCreate');
Route::post('/postStore', [PostController::class, 'store'])->name('postStore');

Route::get('/post/{post}/edit', [PostController::class, 'showEdit'])->name('post_edit');
Route::put('/post/{post}/update', [PostController::class, 'postEdit'])->name('post_update');

Route::delete('/post/{post}/delete', [PostController::class, 'postDelete'])->name('post_delete');

Route::get('/comment/{comment}/edit', [PostController::class, 'showCommentEdit'])->name('comment_edit');
Route::put('/comment/{comment}/update', [PostController::class, 'commentEdit'])->name('comment_update');

Route::delete('/comment/{comment}/delete', [PostController::class, 'commentDelete'])->name('comment_delete');

//User Starts

Route::get('/userHistory', [UserController::class, 'userHistory'])->name('userHistory');

Route::get('/userEdit', [UserController::class, 'showEdit'])->name('userEdit');
Route::post('/userEdit', [UserController::class, 'edit'])->name('edit');


//Auth Starts

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
