<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/ai-responses', [DashboardController::class, 'aiResponses'])->name('ai-responses');
Route::get('/ai-responses/{aiResponse}', [DashboardController::class, 'showAiResponse'])->name('ai-responses.show');
