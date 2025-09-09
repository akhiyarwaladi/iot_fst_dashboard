<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\LogTesterController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'dashboard']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/api-docs', [AdminController::class, 'apiDocs'])->name('admin.api-docs');
});
