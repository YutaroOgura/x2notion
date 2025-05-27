"""
X投稿の前処理用サンプルスクリプト
- 長文分割
- 不要情報除去
- テキスト正規化
"""

import re
from typing import List

def split_long_text(text: str, max_length: int = 500) -> List[str]:
    """長文をmax_lengthごとに分割"""
    return [text[i:i+max_length] for i in range(0, len(text), max_length)]

def remove_unwanted(text: str) -> str:
    """URLや不要な記号を除去"""
    text = re.sub(r'https?://\S+', '', text)  # URL除去
    text = re.sub(r'[#@]\w+', '', text)      # ハッシュタグ・メンション除去
    text = re.sub(r'\s+', ' ', text)         # 余分な空白除去
    return text.strip()

if __name__ == "__main__":
    sample = "これはテスト投稿です。https://example.com #テスト @user"
    print("前処理前:", sample)
    cleaned = remove_unwanted(sample)
    print("前処理後:", cleaned)
    for chunk in split_long_text(cleaned, 10):
        print("分割:", chunk) 