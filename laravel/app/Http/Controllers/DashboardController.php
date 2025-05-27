<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AiResponse;

class DashboardController extends Controller
{
    /**
     * 管理ダッシュボード画面
     */
    public function index()
    {
        $stats = [
            'total_ai_responses' => AiResponse::count(),
            'today_responses' => AiResponse::whereDate('response_time', today())->count(),
            'platform_breakdown' => AiResponse::selectRaw('source_platform, count(*) as count')
                                             ->groupBy('source_platform')
                                             ->get()
                                             ->pluck('count', 'source_platform'),
            'recent_responses' => AiResponse::latest('response_time')->limit(5)->get()
        ];

        return view('dashboard.index', compact('stats'));
    }

    /**
     * AI応答履歴一覧画面
     */
    public function aiResponses(Request $request)
    {
        $query = AiResponse::query();

        // 検索条件の適用
        if ($request->filled('platform')) {
            $query->where('source_platform', $request->platform);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('user_message', 'like', '%' . $request->search . '%')
                  ->orWhere('ai_response', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->where('response_time', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('response_time', '<=', $request->date_to . ' 23:59:59');
        }

        $responses = $query->orderBy('response_time', 'desc')
                          ->paginate(15)
                          ->withQueryString();

        $platforms = AiResponse::distinct()->pluck('source_platform');

        return view('dashboard.ai-responses', compact('responses', 'platforms'));
    }

    /**
     * AI応答詳細画面
     */
    public function showAiResponse(AiResponse $aiResponse)
    {
        return view('dashboard.ai-response-detail', compact('aiResponse'));
    }
}