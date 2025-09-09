<?php

use App\Http\Controllers\LogTesterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('logs', LogTesterController::class);
Route::get('logs/status/{status}', [LogTesterController::class, 'byStatus']);