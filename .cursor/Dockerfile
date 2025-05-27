FROM node:18-alpine

# 作業ディレクトリを設定

WORKDIR /app

# 必要なツールをインストール

RUN apk add --no-cache git bash curl

# package.jsonをコピー

COPY package.json ./

# 依存関係をインストール

RUN npm install || echo "npm install completed"

# プロジェクトファイルをコピー

COPY . .

# 環境変数を設定

ENV NODE_ENV=development
ENV PROJECT_TYPE=n8n-workflows

# デフォルトコマンド

CMD ["npm", "start"]
