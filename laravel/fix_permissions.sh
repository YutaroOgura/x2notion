#!/bin/bash
# Laravel パーミッション修正スクリプト（コンテナ内実行用）
set -e
# storage と cache ディレクトリの所有者・権限を修正
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true 