<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotionController;

// AI応答履歴API
Route::prefix('ai-responses')->group(function () {
    Route::get('/', [NotionController::class, 'getAiResponseHistory']);
    Route::get('/stats', [NotionController::class, 'getStats']);
    Route::get('/{id}', [NotionController::class, 'getAiResponse']);
});

// n8nからのWebhookエンドポイント
Route::prefix('webhooks')->group(function () {
    Route::post('/ai-response', [NotionController::class, 'webhookAiResponse']);
    Route::post('/notion-post', [NotionController::class, 'webhookNotionPost']);
    Route::post('/error', [NotionController::class, 'webhookError']);
});

// 認証が必要なユーザー情報
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');