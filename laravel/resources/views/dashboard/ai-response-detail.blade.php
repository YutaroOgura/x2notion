@extends('layouts.app')

@section('title', 'AI応答詳細 | X2Notion管理')

@section('content')
<div class="space-y-6">
    <!-- ページヘッダー -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">AI応答詳細</h1>
                <p class="text-gray-600 mt-1">ID: {{ $aiResponse->id }}</p>
            </div>
            <a href="{{ route('ai-responses') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                ← 一覧に戻る
            </a>
        </div>
    </div>

    <!-- 基本情報 -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">基本情報</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">プラットフォーム</label>
                <span class="bg-{{ $aiResponse->source_platform === 'slack' ? 'purple' : 'green' }}-100 text-{{ $aiResponse->source_platform === 'slack' ? 'purple' : 'green' }}-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ ucfirst($aiResponse->source_platform) }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">応答日時</label>
                <p class="text-gray-800">{{ $aiResponse->response_time->format('Y年m月d日 H:i:s') }}</p>
            </div>

            @if($aiResponse->user_id)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ユーザーID</label>
                <p class="text-gray-800">{{ $aiResponse->user_id }}</p>
            </div>
            @endif

            @if($aiResponse->tokens_used)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">使用トークン数</label>
                <p class="text-gray-800">{{ number_format($aiResponse->tokens_used) }} tokens</p>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ステータス</label>
                <span class="bg-{{ $aiResponse->status === 'completed' ? 'green' : 'yellow' }}-100 text-{{ $aiResponse->status === 'completed' ? 'green' : 'yellow' }}-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $aiResponse->status === 'completed' ? '完了' : $aiResponse->status }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">作成日時</label>
                <p class="text-gray-600 text-sm">{{ $aiResponse->created_at->format('Y年m月d日 H:i:s') }}</p>
            </div>
        </div>
    </div>

    <!-- メッセージ内容 -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">ユーザーメッセージ</h2>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $aiResponse->user_message }}</p>
        </div>
    </div>

    <!-- AI応答内容 -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">AI応答</h2>
        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $aiResponse->ai_response }}</p>
        </div>
    </div>

    <!-- Notionクエリ情報 -->
    @if($aiResponse->notion_query)
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Notionクエリ</h2>
        <div class="bg-gray-50 rounded-lg p-4">
            <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $aiResponse->notion_query }}</pre>
        </div>
    </div>
    @endif

    <!-- アクション -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">アクション</h2>
        <div class="flex space-x-4">
            <button onclick="copyToClipboard('user-message')" 
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                ユーザーメッセージをコピー
            </button>
            <button onclick="copyToClipboard('ai-response')" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                AI応答をコピー
            </button>
        </div>
    </div>
</div>

<script>
function copyToClipboard(type) {
    let text = '';
    if (type === 'user-message') {
        text = @json($aiResponse->user_message);
    } else if (type === 'ai-response') {
        text = @json($aiResponse->ai_response);
    }
    
    navigator.clipboard.writeText(text).then(function() {
        // 簡単な成功通知
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'コピーしました！';
        button.classList.add('bg-green-500');
        
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('bg-green-500');
        }, 2000);
    });
}
</script>
@endsection