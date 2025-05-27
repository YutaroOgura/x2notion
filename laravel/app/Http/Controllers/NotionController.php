<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AiResponse;
use Illuminate\Http\JsonResponse;

class NotionController extends Controller
{
    /**
     * AI応答履歴一覧取得API
     */
    public function getAiResponseHistory(Request $request): JsonResponse
    {
        $query = AiResponse::query();

        // 検索条件の適用
        if ($request->has('platform')) {
            $query->where('source_platform', $request->platform);
        }

        if ($request->has('date_from')) {
            $query->where('response_time', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('response_time', '<=', $request->date_to);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('user_message', 'like', '%' . $request->search . '%')
                  ->orWhere('ai_response', 'like', '%' . $request->search . '%');
            });
        }

        $responses = $query->orderBy('response_time', 'desc')
                          ->paginate($request->get('per_page', 20));

        return response()->json($responses);
    }

    /**
     * AI応答履歴詳細取得API
     */
    public function getAiResponse(int $id): JsonResponse
    {
        $response = AiResponse::findOrFail($id);
        return response()->json($response);
    }

    /**
     * n8nからのWebhook - AI応答ログ保存
     */
    public function webhookAiResponse(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_message' => 'required|string',
            'ai_response' => 'required|string',
            'source_platform' => 'required|string',
            'user_id' => 'nullable|string',
            'tokens_used' => 'nullable|integer',
            'notion_query' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $validated['response_time'] = now();

        $aiResponse = AiResponse::create($validated);

        return response()->json([
            'success' => true,
            'id' => $aiResponse->id,
            'message' => 'AI応答履歴が正常に保存されました'
        ], 201);
    }

    /**
     * n8nからのWebhook - Notion投稿取得通知
     */
    public function webhookNotionPost(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'post_id' => 'required|string',
            'post_content' => 'required|string',
            'post_date' => 'required|date',
            'post_url' => 'required|url',
            'status' => 'nullable|string'
        ]);

        // ここでは一旦ログ記録のみ
        \Log::info('Notion投稿取得通知', $validated);

        return response()->json([
            'success' => true,
            'message' => 'Notion投稿通知を受信しました'
        ]);
    }

    /**
     * n8nからのWebhook - エラー通知
     */
    public function webhookError(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'error_type' => 'required|string',
            'error_message' => 'required|string',
            'source' => 'required|string',
            'timestamp' => 'nullable|date'
        ]);

        // エラーログ記録
        \Log::error('n8nエラー通知', $validated);

        return response()->json([
            'success' => true,
            'message' => 'エラー通知を受信しました'
        ]);
    }

    /**
     * Notion DB統計情報取得API
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_ai_responses' => AiResponse::count(),
            'today_responses' => AiResponse::whereDate('response_time', today())->count(),
            'platform_breakdown' => AiResponse::selectRaw('source_platform, count(*) as count')
                                             ->groupBy('source_platform')
                                             ->get(),
            'avg_tokens_used' => AiResponse::whereNotNull('tokens_used')->avg('tokens_used')
        ];

        return response()->json($stats);
    }
}
