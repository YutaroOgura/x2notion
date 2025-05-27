# Laravel管理UI/API概要

## 目的
- X投稿・AI応答履歴の閲覧や検索、n8n/Python連携用のAPI/Webhookを提供

## セットアップ手順（初回）
```bash
cd laravel
composer install
cp .env.example .env
php artisan key:generate
# 必要に応じてDB等の設定を編集
php artisan migrate
php artisan serve
```

## 想定機能（v1.0）
- X投稿一覧・検索画面（Notion DBから取得）
- AI応答履歴の一覧・検索
- n8n/Pythonから呼び出せるWebhook/API

## 今後の拡張方針
- 投稿・応答データのタグ付けやメモ機能
- 管理用の簡易ダッシュボード
- 認証・権限管理の強化

## 注意事項
- Notionアカウント・DBは固定。設定は.envで管理
- 本ディレクトリは雛形です。必要に応じてartisanコマンド等で構成を拡張してください 