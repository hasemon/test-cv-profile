<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('profile', [UserProfileController::class, 'index']);
Route::post('profile', [UserProfileController::class, 'store']);
Route::delete('profile/{id}', [UserProfileController::class, 'destroy']);
Route::get('/profile/{id}/comments', [CommentController::class, 'index']);
Route::post('/profile/{id}/comments', [CommentController::class, 'store']);
