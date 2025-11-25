<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPreferencesController;
use Illuminate\Support\Facades\Route;

Route::post('/users/sign-up', [UserController::class, 'signUp']);
Route::post('/users/sign-in', [UserController::class, 'signIn']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/sign-out', [UserController::class, 'signOut']);
    Route::get('/users/current', [UserController::class, 'currentUser']);
    Route::put('/user-preferences', [UserPreferencesController::class, 'update']);

    Route::get('/preferred-articles', [ArticleController::class, 'preferredArticles']);
    Route::apiResource('articles', ArticleController::class)->only(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
    Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
});
