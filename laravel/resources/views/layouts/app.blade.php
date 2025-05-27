<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'X2Notion管理画面')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">
                <a href="{{ route('dashboard') }}">X2Notion管理</a>
            </h1>
            <div class="space-x-4">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-200">ダッシュボード</a>
                <a href="{{ route('ai-responses') }}" class="hover:text-blue-200">AI応答履歴</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-6 px-4">
        @yield('content')
    </main>

    <script>
        // 簡単なJavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // フォームのリアルタイム検索
            const searchInputs = document.querySelectorAll('[data-search]');
            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.form.submit();
                    }, 500);
                });
            });
        });
    </script>
</body>
</html>