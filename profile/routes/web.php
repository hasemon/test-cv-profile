<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', [ProfileController::class,'index'])->name('profile.index');
Route::get('/create', [ProfileController::class,'create'])->name('profile.create');
Route::post('/store', [ProfileController::class,'store'])->name('profile.store');
Route::get('/edit/{profile}', [ProfileController::class,'edit'])->name('profile.edit');
Route::put('/update/{profile}', [ProfileController::class,'update'])->name('profile.update');
Route::delete('/delete/{profile}', [ProfileController::class,'destroy'])->name('profile.destroy');


// Education
Route::post('/education/store', [ProfileController::class, 'storeEducation'])->name('education.store');
Route::delete('/education/delete/{id}', [ProfileController::class, 'deleteEducation'])->name('education.delete');

// Comment
Route::post('/comment/store', [ProfileController::class, 'storeComment'])->name('comment.store');
Route::delete('/comment/delete/{id}', [ProfileController::class, 'deleteComment'])->name('comment.delete');
