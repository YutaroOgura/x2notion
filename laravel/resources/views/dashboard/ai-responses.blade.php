@extends('layouts.app')

@section('title', 'AI応答履歴 | X2Notion管理')

@section('content')
<div class="space-y-6">
    <!-- ページタイトルと検索フォーム -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">AI応答履歴</h1>
            <div class="text-sm text-gray-600">
                全{{ number_format($responses->total()) }}件
            </div>
        </div>

        <!-- 検索・フィルターフォーム -->
        <form method="GET" action="{{ route('ai-responses') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">キーワード検索</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="メッセージ内容で検索"
                           data-search
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">プラットフォーム</label>
                    <select name="platform" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">すべて</option>
                        @foreach($platforms as $platform)
                            <option value="{{ $platform }}" {{ request('platform') == $platform ? 'selected' : '' }}>
                                {{ ucfirst($platform) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">開始日</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">終了日</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('ai-responses') }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                    クリア
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    検索
                </button>
            </div>
        </form>
    </div>

    <!-- 応答履歴一覧 -->
    @if($responses->count() > 0)
    <div class="bg-white rounded-lg shadow">
        <div class="divide-y divide-gray-200">
            @foreach($responses as $response)
            <div class="p-6 hover:bg-gray-50">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="bg-{{ $response->source_platform === 'slack' ? 'purple' : 'green' }}-100 text-{{ $response->source_platform === 'slack' ? 'purple' : 'green' }}-800 px-2 py-1 rounded text-xs font-medium">
                                {{ ucfirst($response->source_platform) }}
                            </span>
                            <span class="text-gray-500 text-sm">
                                {{ $response->response_time->format('Y/m/d H:i:s') }}
                            </span>
                            @if($response->tokens_used)
                            <span class="text-gray-400 text-xs">
                                {{ number_format($response->tokens_used) }} tokens
                            </span>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-700">ユーザー:</span>
                                <p class="text-gray-800">{{ Str::limit($response->user_message, 150) }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">AI応答:</span>
                                <p class="text-gray-600">{{ Str::limit($response->ai_response, 200) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="ml-4 flex-shrink-0">
                        <a href="{{ route('ai-responses.show', $response) }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            詳細
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ページネーション -->
    <div class="bg-white rounded-lg shadow p-4">
        {{ $responses->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <div class="text-gray-400 mb-4">
            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">AI応答履歴が見つかりません</h3>
        <p class="text-gray-500">
            @if(request()->hasAny(['search', 'platform', 'date_from', 'date_to']))
                検索条件を変更してもう一度お試しください。
            @else
                まだAI応答履歴がありません。n8nワークフローが動作すると履歴が表示されます。
            @endif
        </p>
    </div>
    @endif
</div>
@endsection