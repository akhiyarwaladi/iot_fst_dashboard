<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\LogTesterController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'dashboard']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/logs', [AdminController::class, 'logs'])->name('admin.logs');
    Route::get('/components', [AdminController::class, 'components'])->name('admin.components');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/api-docs', [AdminController::class, 'apiDocs'])->name('admin.api-docs');
    Route::get('/network', [AdminController::class, 'network'])->name('admin.network');
    
    // IoT Device Management
    Route::get('/temperature', [AdminController::class, 'temperature'])->name('admin.temperature');
    Route::get('/switches', [AdminController::class, 'switches'])->name('admin.switches');
    Route::get('/environmental', [AdminController::class, 'environmental'])->name('admin.environmental');
});
