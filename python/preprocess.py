"""
X投稿の前処理用サンプルスクリプト
- 長文分割
- 不要情報除去
- テキスト正規化
"""

import re
from typing import List
from flask import Flask, request, jsonify

def split_long_text(text: str, max_length: int = 500) -> List[str]:
    """長文をmax_lengthごとに分割"""
    return [text[i:i+max_length] for i in range(0, len(text), max_length)]

def remove_unwanted(text: str) -> str:
    """URLや不要な記号を除去"""
    text = re.sub(r'https?://\S+', '', text)  # URL除去
    text = re.sub(r'[#@]\w+', '', text)      # ハッシュタグ・メンション除去
    text = re.sub(r'\s+', ' ', text)         # 余分な空白除去
    return text.strip()

def preprocess_text(text: str, max_length: int = 500) -> list:
    cleaned = remove_unwanted(text)
    chunks = split_long_text(cleaned, max_length)
    return chunks

app = Flask(__name__)

@app.route('/preprocess', methods=['POST'])
def preprocess_api():
    data = request.get_json()
    text = data.get('text', '')
    max_length = int(data.get('max_length', 500))
    result = preprocess_text(text, max_length)
    return jsonify({
        'chunks': result,
        'original_length': len(text),
        'chunk_count': len(result)
    })

if __name__ == "__main__":
    import sys
    if len(sys.argv) > 1 and sys.argv[1] == 'api':
        app.run(host='0.0.0.0', port=5000)
    else:
        sample = "これはテスト投稿です。https://example.com #テスト @user"
        print("前処理前:", sample)
        cleaned = remove_unwanted(sample)
        print("前処理後:", cleaned)
        for chunk in split_long_text(cleaned, 10):
            print("分割:", chunk) 