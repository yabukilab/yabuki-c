// ==============================
// 共通関数
// ==============================

// カタカナ→ひらがな変換（伸ばし棒は残す）
function katakanaToHiragana(str) {
  return str.replace(/[ァ-ヶ]/g, ch =>
    String.fromCharCode(ch.charCodeAt(0) - 0x60)
  );
}

// 小文字正規化（ゃ→や など）
function normalizeSmallKana(char) {
  const map = {
    'ぁ': 'あ', 'ぃ': 'い', 'ぅ': 'う', 'ぇ': 'え', 'ぉ': 'お',
    'ゃ': 'や', 'ゅ': 'ゆ', 'ょ': 'よ'
  };
  return map[char] || char;
}

// 単語の末尾を取得（伸ばし棒は直前の文字を利用）
function getValidLastChar(word) {
  if (!word) return null;
  const w = katakanaToHiragana(word);
  let last = w.slice(-1);

  // 末尾が伸ばし棒なら直前の文字を見る
  if (last === 'ー' && w.length > 1) {
    last = w.slice(-2, -1);
  }

  return normalizeSmallKana(last);
}

// 単語の先頭を取得
function getValidFirstChar(word) {
  const w = katakanaToHiragana(word);
  return normalizeSmallKana(w[0]);
}

// ログを最下部までスクロール
function scrollLogToBottom() {
  const log = document.getElementById('log');
  log.scrollTop = log.scrollHeight;
}

// ==============================
// ゲーム用変数
// ==============================
let remainingTime = 60;
let gameInterval = null;
let turnCount = 0;
let gameEnded = false;
let previousWord = null;
let requiredInitial = null;
let usedWords = []; // プレイヤー+AI両方の履歴

// ユーザー情報（localStorageから取得）
let userId = parseInt(localStorage.getItem('user_id')) || null;

// ==============================
// サーバーへスコア保存
// ==============================
function saveScoreToServer(userId, score, playTime) {
  fetch('save_score.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      user_id: userId,
      score: score,
      play_time: playTime
    })
  })
    .then(res => res.json())
    .then(data => {
      console.log("📡 スコア保存結果:", data);
    })
    .catch(error => {
      console.error('❌ 通信エラー:', error);
    });
}

// ==============================
// 画面表示の更新
// ==============================
function updateDisplays() {
  document.getElementById('timer').textContent = `残り時間: ${remainingTime}秒`;
  document.getElementById('turnCount').textContent = `ターン数: ${turnCount}`;
}

// ==============================
// タイマー開始
// ==============================
function startTimer() {
  updateDisplays();
  gameInterval = setInterval(() => {
    if (remainingTime <= 0) {
      endGame("⏰ 制限時間終了！");
    } else {
      remainingTime--;
      updateDisplays();
    }
  }, 1000);
}

// ==============================
// ゲーム終了処理
// ==============================
function endGame(message) {
  clearInterval(gameInterval);
  gameEnded = true;

  document.getElementById('playerInput').disabled = true;
  document.getElementById('submitBtn').disabled = true;
  document.getElementById('restartBtn').style.display = 'inline-block';
  document.getElementById('menuBtn').style.display = 'inline-block';
  document.getElementById('scoreBtn').style.display = 'inline-block';

  const log = document.getElementById('log');
  const endMessage = document.createElement('div');
  endMessage.textContent = `${message} 合計ターン数: ${turnCount}`;
  log.appendChild(endMessage);
  scrollLogToBottom();

  if (userId) {
    saveScoreToServer(userId, turnCount, 60 - remainingTime);
  }
}

// ==============================
// ゲーム初期化
// ==============================
function resetGame() {
  clearInterval(gameInterval);
  remainingTime = 60;
  turnCount = 0;
  gameEnded = false;
  previousWord = null;
  usedWords = [];
  requiredInitial = getRandomHiragana();

  document.getElementById('log').innerHTML = "";
  document.getElementById('playerInput').disabled = false;
  document.getElementById('submitBtn').disabled = false;
  document.getElementById('playerInput').value = "";
  document.getElementById('restartBtn').style.display = 'none';
  document.getElementById('menuBtn').style.display = 'none';
  document.getElementById('scoreBtn').style.display = 'none';
  updateDisplays();

  const startMessage = document.createElement('div');
  startMessage.textContent = `🎲 ゲーム開始：「${requiredInitial}」から始まる単語を入力してください！`;
  document.getElementById('log').appendChild(startMessage);
  scrollLogToBottom();

  startTimer();
}

// ==============================
// 単語関連処理
// ==============================
function getRandomHiragana() {
  const base = 'あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわ';
  return base[Math.floor(Math.random() * base.length)];
}

// 共通: 単語が辞書に存在するかチェック
function isWordInDictionary(word, dictionary) {
  const wordHira = katakanaToHiragana(word);
  const allWords = Object.values(dictionary).flat();
  return allWords.includes(wordHira);
}

// ==============================
// DOMロード時の処理
// ==============================
document.addEventListener('DOMContentLoaded', () => {
  resetGame();

  document.getElementById('restartBtn').addEventListener('click', resetGame);
  document.getElementById('scoreBtn').addEventListener('click', () => {
    location.href = 'user_scores.php';
  });
  document.getElementById('menuBtn').addEventListener('click', () => {
    location.href = 'menu.php';
  });

  document.getElementById('playerInput').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      document.getElementById('submitBtn').click();
    }
  });
});

// ==============================
// プレイヤー入力処理
// ==============================
document.getElementById('submitBtn').addEventListener('click', () => {
  if (gameEnded) return;

  const input = document.getElementById('playerInput');
  const word = input.value.trim();
  if (!word) return;

  fetch('./data/words_large_corrected.json')
    .then(response => response.json())
    .then(dictionary => {
      const wordHira = katakanaToHiragana(word);

      // ✅ 共通関数で辞書チェック
      if (!isWordInDictionary(word, dictionary)) {
        alert("❌ この単語は辞書に登録されていません。");
        return;
      }
      if (usedWords.includes(wordHira)) {
        alert("❌ この単語はすでに使われています。");
        return;
      }
      if (previousWord) {
        const expected = getValidLastChar(previousWord);
        if (getValidFirstChar(wordHira) !== expected) {
          alert(`❌ 前の単語は「${previousWord}」です。「${expected}」で始まる単語を入力してください。`);
          return;
        }
      } else if (getValidFirstChar(wordHira) !== requiredInitial) {
        alert(`❌ 最初の単語は「${requiredInitial}」で始まる必要があります。`);
        return;
      }

      // プレイヤーの入力をログに追加
      const log = document.getElementById('log');
      const entry = document.createElement('div');
      entry.textContent = `🧑 プレイヤー: ${word}`;
      log.appendChild(entry);
      scrollLogToBottom();

      input.value = "";
      previousWord = word;
      usedWords.push(wordHira);
      turnCount++;
      updateDisplays();

      // AIの応答処理
      const lastChar = getValidLastChar(word);
      const candidates = dictionary[lastChar] || [];
      const available = candidates.filter(w => !usedWords.includes(w));

      const aiEntry = document.createElement('div');
      if (available.length === 0) {
        aiEntry.textContent = '🤖 コンピューター: （該当なし）';
        log.appendChild(aiEntry);
        endGame("🤖 コンピューターが詰みました！");
      } else {
        const aiWord = available[Math.floor(Math.random() * available.length)];
        aiEntry.textContent = `🤖 コンピューター: ${aiWord}`;
        log.appendChild(aiEntry);
        previousWord = aiWord;
        usedWords.push(aiWord);
        turnCount++;
        updateDisplays();
      }
      scrollLogToBottom();
    });
});
