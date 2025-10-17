<?php

use App\Http\Controllers\API\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('profile', [UserProfileController::class, 'index']);
Route::post('profile', [UserProfileController::class, 'store']);
