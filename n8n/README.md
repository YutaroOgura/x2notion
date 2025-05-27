# n8nフロー概要

## 目的
- X（旧Twitter）→Notion保存、AI分析・チャット応答、エラー通知などの自動化フローをn8nで構築

## フロー一覧
- `x_fetch_to_notion.json`：X投稿取得→Notion保存フロー
- `ai_answer_flow.json`：Slack/LINE→Notion→AI→回答フロー
- `error_notify_flow.json`：エラー時Slack通知フロー

## インポート方法
1. n8nの管理画面にアクセス
2. 「Import」から各jsonファイルをアップロード
3. 必要に応じてAPIキーやWebhook URL、Slackチャネル等を設定

## カスタマイズ例
- 投稿取得間隔や検索条件の変更
- AIプロンプトや前処理ロジックの調整
- 通知先チャネルやエラー処理の拡張

## 注意事項
- APIキー・認証情報はn8nの環境変数または.envで安全に管理してください
- フローの編集・運用は誤操作防止のため権限管理を推奨します 