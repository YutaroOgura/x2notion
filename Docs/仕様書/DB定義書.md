# DB定義書

## 1. Notion データベース

Notionデータベースは、X（旧Twitter）の投稿を保存するために使用されます。

| カラム名     | 型         | 必須 | 説明                       |
|--------------|------------|------|----------------------------|
| 投稿日付     | Date       | ○    | X投稿の日時                |
| 投稿内容     | Text       | ○    | 本文                       |
| リプライ情報 | Text/JSON  |      | リプライ先・内容           |
| RT情報       | Number/Text|      | RT数・元投稿情報           |
| 画像         | URL/Files  |      | メディアURL                |
| 返信情報     | Text/JSON  |      | 返信先・内容               |
| X投稿ID      | Text       | ○    | 一意なID（重複防止用）     |
| 投稿URL      | URL        | ○    | X上の投稿URL               |
| 取得日時     | DateTime   | ○    | システムが取得した日時     |
| いいね数     | Number     |      | いいねの数                 |
| リプライ数   | Number     |      | リプライの数               |
| 引用数       | Number     |      | 引用の数                   |
| タイプ       | Select     |      | 投稿タイプ（通常/リプライ/リツイート/引用） |
| ハッシュタグ | Multi-Select|     | 投稿に含まれるハッシュタグ |
| メンション   | Text       |      | 投稿に含まれるメンション   |
| 画像・メディア| Text      |      | 添付メディアのURL          |

## 2. Laravel データベース

### 2.1 AI応答履歴テーブル (ai_responses)

| カラム名        | 型         | NULL | 説明                       |
|-----------------|------------|------|----------------------------|
| id              | bigint     | No   | 主キー（自動採番）         |
| user_message    | text       | No   | ユーザーからの質問内容     |
| ai_response     | text       | No   | AIからの応答内容           |
| source_platform | varchar    | No   | 送信元プラットフォーム（slack/line） |
| user_id         | varchar    | Yes  | ユーザーID                 |
| response_time   | timestamp  | No   | 応答時刻                   |
| tokens_used     | integer    | Yes  | 使用したトークン数         |
| notion_query    | text       | Yes  | Notion検索に使用したクエリ |
| status          | varchar    | No   | 応答ステータス（completed等） |
| created_at      | timestamp  | Yes  | レコード作成日時           |
| updated_at      | timestamp  | Yes  | レコード更新日時           |

### 2.2 ユーザーテーブル (users)

標準的なLaravelユーザーテーブル（認証用）

### 2.3 キャッシュテーブル (cache)

システムキャッシュ用テーブル

### 2.4 ジョブテーブル (jobs)

非同期ジョブ管理用テーブル
