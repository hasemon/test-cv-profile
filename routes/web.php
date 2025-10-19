<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\CommentController;


// Profile Routes
Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/edit/{profile}', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/update/{profile}', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/delete/{profile}', [ProfileController::class, 'destroy'])->name('profile.destroy');


// Education
Route::post('/education/store', [EducationController::class, 'store'])->name('education.store');
Route::delete('/education/delete/{id}', [EducationController::class, 'destroy'])->name('education.delete');


// Comment 
Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
Route::delete('/comment/delete/{id}', [CommentController::class, 'destroy'])->name('comment.delete');
