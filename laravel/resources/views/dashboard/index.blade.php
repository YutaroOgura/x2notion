@extends('layouts.app')

@section('title', 'ダッシュボード | X2Notion管理')

@section('content')
<div class="space-y-6">
    <!-- ページタイトル -->
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800">ダッシュボード</h1>
        <p class="text-gray-600 mt-2">X2Notionシステムの状況を確認できます</p>
    </div>

    <!-- 統計カード -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">総AI応答数</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_ai_responses']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">今日の応答数</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['today_responses']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">プラットフォーム数</p>
                    <p class="text-2xl font-bold text-gray-900">{{ count($stats['platform_breakdown']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- プラットフォーム別使用状況 -->
    @if(count($stats['platform_breakdown']) > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">プラットフォーム別使用状況</h2>
        <div class="space-y-3">
            @foreach($stats['platform_breakdown'] as $platform => $count)
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                    <span class="font-medium text-gray-700 capitalize">{{ $platform }}</span>
                </div>
                <span class="text-gray-600">{{ number_format($count) }}回</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 最近のAI応答 -->
    @if($stats['recent_responses']->count() > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">最近のAI応答</h2>
            <a href="{{ route('ai-responses') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                すべて見る →
            </a>
        </div>
        <div class="space-y-4">
            @foreach($stats['recent_responses'] as $response)
            <div class="border-l-4 border-blue-500 pl-4 py-2">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">{{ Str::limit($response->user_message, 60) }}</p>
                        <p class="text-gray-600 text-sm mt-1">{{ Str::limit($response->ai_response, 80) }}</p>
                        <div class="flex items-center mt-2 text-xs text-gray-500">
                            <span class="bg-gray-200 px-2 py-1 rounded">{{ $response->source_platform }}</span>
                            <span class="ml-2">{{ $response->response_time->format('Y/m/d H:i') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('ai-responses.show', $response) }}" class="text-blue-600 hover:text-blue-800 text-sm ml-4">
                        詳細
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <p class="text-gray-500">まだAI応答履歴がありません</p>
    </div>
    @endif
</div>
@endsection