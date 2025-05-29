# APIルーティング一覧

## 1. Laravel API エンドポイント

### 1.1 AI応答履歴API

| メソッド | エンドポイント | コントローラーメソッド | 説明 |
|----------|----------------|------------------------|------|
| GET | /api/ai-responses | NotionController@getAiResponseHistory | AI応答履歴一覧取得 |
| GET | /api/ai-responses/stats | NotionController@getStats | AI応答統計情報取得 |
| GET | /api/ai-responses/{id} | NotionController@getAiResponse | 特定のAI応答詳細取得 |

### 1.2 Webhook エンドポイント

| メソッド | エンドポイント | コントローラーメソッド | 説明 |
|----------|----------------|------------------------|------|
| POST | /api/webhooks/ai-response | NotionController@webhookAiResponse | AI応答ログ保存 |
| POST | /api/webhooks/notion-post | NotionController@webhookNotionPost | Notion投稿通知受信 |
| POST | /api/webhooks/error | NotionController@webhookError | エラー通知受信 |

### 1.3 認証API

| メソッド | エンドポイント | 説明 |
|----------|----------------|------|
| GET | /api/user | 認証済みユーザー情報取得（Sanctumミドルウェア使用） |

## 2. n8n Webhook エンドポイント

### 2.1 メッセージ受信Webhook

| メソッド | エンドポイント | ワークフロー | 説明 |
|----------|----------------|-------------|------|
| POST | /webhook/slack-events | ai_answer_flow | Slackイベント受信 |
| POST | /webhook/line-webhook | ai_answer_flow | LINEメッセージ受信 |

## 3. 外部API連携

### 3.1 X API

| メソッド | エンドポイント | 説明 |
|----------|----------------|------|
| GET | https://api.twitter.com/2/users/{user_id}/tweets | ユーザータイムライン取得 |

### 3.2 Notion API

| メソッド | エンドポイント | 説明 |
|----------|----------------|------|
| POST | https://api.notion.com/v1/pages | ページ（レコード）作成 |
| POST | https://api.notion.com/v1/databases/{database_id}/query | データベース検索 |

### 3.3 OpenAI API

| メソッド | エンドポイント | 説明 |
|----------|----------------|------|
| POST | https://api.openai.com/v1/chat/completions | チャット応答生成 |

### 3.4 Slack API

| メソッド | エンドポイント | 説明 |
|----------|----------------|------|
| POST | https://slack.com/api/chat.postMessage | メッセージ送信 |

### 3.5 LINE API

| メソッド | エンドポイント | 説明 |
|----------|----------------|------|
| POST | https://api.line.me/v2/bot/message/reply | 返信メッセージ送信 |

## 4. Python API エンドポイント

| メソッド | エンドポイント | 説明 |
|----------|----------------|------|
| POST | /preprocess | テキスト前処理（長文分割、不要情報除去、正規化） |
