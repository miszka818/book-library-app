<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'me']);

Route::middleware('auth:sanctum')->group(function () {

    //BOOKS
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);

    //USER BOOKS
    Route::get('/user-books', [UserBookController::class, 'index']);
    Route::post('/user-books', [UserBookController::class, 'store']);
    Route::get('/user-books/{userBook}', [UserBookController::class, 'show']);
    Route::put('/user-books/{userBook}', [UserBookController::class, 'update']);
    Route::delete('/user-books/{userBook}', [UserBookController::class, 'destroy']);

    //GROUPS
    Route::get('/groups', [GroupController::class, 'index']);
    Route::post('/groups', [GroupController::class, 'store']);
    Route::get('/groups/{group}', [GroupController::class, 'show']);
    Route::put('/groups/{group}', [GroupController::class, 'update']);
    Route::delete('/groups/{group}', [GroupController::class, 'destroy']);


    Route::post('/groups/{group}/add-user-book', [GroupController::class, 'addUserBook']);
    Route::delete('/groups/{group}/remove-user-book/{userBook}', [GroupController::class, 'removeUserBook']);

    //TAGS
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::get('/tags/{tag}', [TagController::class, 'show']);
    Route::put('/tags/{tag}', [TagController::class, 'update']);
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']);
});