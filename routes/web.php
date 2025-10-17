<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\CommentController;
use App\Models\Profile;

// Global route for the single profile's ID (or 0 if not exists)
// Determines whether to show the profile or the creation page.
Route::get('/', function () {
    $profile = Profile::first();
    if ($profile) {
        return redirect()->route('profile.show');
    }
    return redirect()->route('profile.create');
})->name('home');

// Profile Routes (Singular management)
Route::prefix('profile')->group(function () {
    Route::get('create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/', [ProfileController::class, 'store'])->name('profile.store');

    // These routes rely on the Profile::first() logic in the controller
    Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.delete');
});

// Education Routes (Linked to the single profile)
Route::post('education', [EducationController::class, 'store'])->name('education.store');
// for updating an existing education entry
Route::put('education/{education}', [EducationController::class, 'update'])->name('education.update'); // 🆕 added
Route::delete('education/{education}', [EducationController::class, 'destroy'])->name('education.destroy');

// Comment Route (Linked to the single profile)
Route::post('comments', [CommentController::class, 'store'])->name('comments.store');