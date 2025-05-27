# X→Notion連携ツール（プロジェクト概要）

## 概要
- X（旧Twitter）の特定ユーザ投稿をNotion DBに自動保存し、AI分析・チャット応答・Slack/LINE通知まで一気通貫で自動化するシステム
- n8nによるAPI連携・自動化、Laravelによる管理UI/API、Pythonによる前処理を組み合わせて運用

## ディレクトリ構成
```
ogura_work/x2notion/
├── Docs/                # 設計・仕様ドキュメント
├── n8n/                 # n8nフロー定義・README
├── laravel/             # Laravel管理UI/API
├── python/              # 補助的なPythonスクリプト
├── .env.example         # 各種APIキー・設定例
├── docker-compose.yml   # サービス統合用
└── README.md            # 本ファイル
```

## 起動手順（例）
1. `.env.example` をコピーして `.env` を作成し、各種APIキー等を設定
2. `docker-compose up -d` で全サービス起動
3. n8n管理画面（http://localhost:5678）でフローをインポート・設定
4. Laravel（http://localhost:8000）やPythonスクリプトも必要に応じて利用

## 各サービスの役割
- **n8n**：X→Notion保存、AI分析、Slack/LINE通知などの自動化フロー
- **Laravel**：投稿・AI応答履歴の閲覧、Webhook/API提供
- **Python**：テキスト前処理やAI連携の補助

## 今後の拡張方針
- 複数ユーザ対応、通知機能、外部サービス連携、Dify等AIワークフロー拡張も容易に追加可能

## 注意事項
- Notionアカウント・DBは固定、データの外部公開は禁止
- APIキー・認証情報は.envで厳重管理

---

> 詳細はDocs/配下の設計ドキュメントを参照してください。 