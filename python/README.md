# Python補助スクリプト概要

## 目的
- n8nフローやAI連携で必要となるテキスト前処理・データ整形を補助

## 主なスクリプト
- `preprocess.py`：X投稿の長文分割・不要情報除去などの前処理関数サンプル

## 使い方
```bash
python preprocess.py
```
- サンプルテキストの前処理・分割結果が出力されます
- n8nのPythonノードや外部APIからも呼び出し可能

## 拡張例
- 固有表現抽出やキーワード抽出の追加
- 言語判定や翻訳処理の追加
- AIプロンプト用のテキスト整形

## APIサーバとしての利用

```bash
# Flask APIサーバ起動（ポート5000）
python preprocess.py api
```

- POST /preprocess
  - body: { "text": "処理したいテキスト", "max_length": 500 }
  - response: { "chunks": ["..."], "original_length": 123, "chunk_count": 2 }

### curl例
```bash
curl -X POST http://localhost:5000/preprocess \
  -H "Content-Type: application/json" \
  -d '{"text": "これはテスト投稿です。https://example.com #テスト @user", "max_length": 10}'
```

### n8n HTTP Requestノード例
- Method: POST
- URL: http://python:5000/preprocess
- Body: JSON
  - text: 送信テキスト
  - max_length: 分割長（省略可）

## 注意事項
- 本スクリプトは雛形です。用途に応じて自由に拡張してください 