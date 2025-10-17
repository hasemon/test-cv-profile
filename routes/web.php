<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\CommentController;

Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');
Route::resource('profiles', ProfileController::class);
Route::resource('profiles.educations', EducationController::class)->shallow();
Route::post('profiles/{profile}/comments', [CommentController::class, 'store'])->name('comments.store');

