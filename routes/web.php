<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/patients', [AdminController::class, 'index'])->name('admin.patients.index');
    Route::get('/patients/create', [AdminController::class, 'create'])->name('admin.patients.create');
    Route::post('/patients', [AdminController::class, 'store'])->name('admin.patients.store');
    Route::get('/patients/{patient}/edit', [AdminController::class, 'edit'])->name('admin.patients.edit');
    Route::put('/patients/{patient}', [AdminController::class, 'update'])->name('admin.patients.update');
    Route::delete('/patients/{patient}', [AdminController::class, 'destroy'])->name('admin.patients.destroy');
    Route::post('/patients/{patient}/restore', [AdminController::class, 'restore'])->name('admin.patients.restore');
    Route::get('/patients/search', [AdminController::class, 'search'])->name('admin.patients.search');
});

require __DIR__.'/auth.php';
