// ==============================
// 共通関数
// ==============================

// カタカナ→ひらがな変換（伸ばし棒「ー」はそのまま残す）
function katakanaToHiragana(str) {
  return str.replace(/[ァ-ヶ]/g, ch =>
    String.fromCharCode(ch.charCodeAt(0) - 0x60)
  );
}

// 小文字→大文字に正規化（ぁぃぅぇぉゃゅょ を あいうえおやゆよ に）
function normalizeSmallKana(char) {
  const map = {
    'ぁ': 'あ', 'ぃ': 'い', 'ぅ': 'う', 'ぇ': 'え', 'ぉ': 'お',
    'ゃ': 'や', 'ゅ': 'ゆ', 'ょ': 'よ'
  };
  return map[char] || char;
}

// ログを最下部までスクロール
function scrollLogToBottom() {
  const log = document.getElementById('log');
  log.scrollTop = log.scrollHeight;
}

// 単語の末尾を取得（末尾が「ー」ならその一つ前を末尾として扱う）
function getValidLastChar(word) {
  if (!word) return null;
  const w = katakanaToHiragana(word);
  let last = w.slice(-1);
  if (last === 'ー' && w.length > 1) {
    last = w.slice(-2, -1);
  }
  return normalizeSmallKana(last);
}

// 単語の先頭を取得（最初の文字を小文字正規化）
function getValidFirstChar(word) {
  const w = katakanaToHiragana(word);
  return normalizeSmallKana(w[0]);
}

// ==============================
// ゲーム変数
// ==============================
let remainingTime = 60;
let gameInterval = null;
let turnCount = 0;
let gameEnded = false;
let previousWord = null;      // 最新の置かれた単語（AI/プレイヤー両方）
let requiredInitial = null;   // 次にプレイヤーが入力すべき先頭文字
let usedWords = [];           // 辞書上の単語（ひらがな）で履歴保持
let userId = parseInt(localStorage.getItem('user_id')) || null;

// ==============================
// サーバーへスコア保存
// ==============================
function saveScoreToServer(userId, score, playTime) {
  if (!userId) return;
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
// 表示更新
// ==============================
function updateDisplays() {
  const timerEl = document.getElementById('timer');
  const turnEl = document.getElementById('turnCount');
  if (timerEl) timerEl.textContent = `残り時間: ${remainingTime}秒`;
  if (turnEl) turnEl.textContent = `ターン数: ${turnCount}`;
}

// ==============================
// タイマー関連
// ==============================
function startTimer() {
  updateDisplays();
  if (gameInterval) clearInterval(gameInterval);
  gameInterval = setInterval(() => {
    if (remainingTime <= 0) {
      endGame("⏰ 制限時間終了！");
    } else {
      remainingTime--;
      updateDisplays();
    }
  }, 1000);
}

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

  // play_time を elapsed 秒で送る（60 - remainingTime）
  if (userId !== null) {
    saveScoreToServer(userId, turnCount, 60 - remainingTime);
  }
}

// ==============================
// ランダム補助
// ==============================
function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

// ==============================
// 辞書チェック（汎用）
// ==============================
function isWordInDictionaryAsHiragana(wordHira, dictionary) {
  const all = Object.values(dictionary).flat();
  return all.includes(wordHira);
}

// ==============================
// ゲーム初期化（辞書から最初の単語を選ぶ）
// ==============================
function resetGame() {
  clearInterval(gameInterval);
  remainingTime = 60;
  turnCount = 0;
  gameEnded = false;
  previousWord = null;
  usedWords = [];
  requiredInitial = null;

  document.getElementById('log').innerHTML = "";
  document.getElementById('playerInput').disabled = false;
  document.getElementById('submitBtn').disabled = false;
  document.getElementById('playerInput').value = "";
  document.getElementById('restartBtn').style.display = 'none';
  document.getElementById('menuBtn').style.display = 'none';
  document.getElementById('scoreBtn').style.display = 'none';
  updateDisplays();

  fetch('./data/words_large_corrected.json')
    .then(res => res.json())
    .then(dictionary => {
      const allWords = Object.values(dictionary).flat();
      if (!allWords || allWords.length === 0) {
        const log = document.getElementById('log');
        log.textContent = '辞書が読み込めません。';
        return;
      }
      const startWord = allWords[getRandomInt(allWords.length)];
      previousWord = startWord;
      usedWords.push(startWord);
      requiredInitial = getValidLastChar(startWord);

      const log = document.getElementById('log');
      const startMessage = document.createElement('div');
      startMessage.textContent = `🎲 ゲーム開始！最初の単語は「${startWord}」です。`;
      log.appendChild(startMessage);

      const promptMessage = document.createElement('div');
      promptMessage.textContent = `🧑 あなたの番です。「${requiredInitial}」で始まる単語を入力してください！`;
      log.appendChild(promptMessage);

      scrollLogToBottom();
      startTimer();
      updateDisplays();
      document.getElementById('submitBtn').disabled = false;
    })
    .catch(err => {
      console.error('辞書読み込みエラー', err);
      const log = document.getElementById('log');
      log.textContent = '辞書の読み込みに失敗しました。';
    });
}

// ==============================
// DOM ロード後のイベント設定
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
// プレイヤーの入力処理
// ==============================
document.getElementById('submitBtn').addEventListener('click', () => {
  if (gameEnded) return;

  const inputEl = document.getElementById('playerInput');
  let raw = inputEl.value.trim();
  if (!raw) return;

  const wordHira = katakanaToHiragana(raw);

  fetch('./data/words_large_corrected.json')
    .then(res => res.json())
    .then(dictionary => {
      // ✅ まず「ん」で終わったかチェック
      if (getValidLastChar(wordHira) === 'ん') {
        const log = document.getElementById('log');
        const playerEntry = document.createElement('div');
        playerEntry.textContent = `🧑 プレイヤー: ${wordHira}`;
        log.appendChild(playerEntry);

        const endEntry = document.createElement('div');
        endEntry.textContent = `❌『ん』で終わったため、ゲームオーバー！`;
        log.appendChild(endEntry);
        scrollLogToBottom();

        endGame("❌『ん』で終わったため、ゲームオーバー！");
        return; // ← コンピューターには進まない
      }

      // 辞書チェック
      if (!isWordInDictionaryAsHiragana(wordHira, dictionary)) {
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

      const log = document.getElementById('log');
      const playerEntry = document.createElement('div');
      playerEntry.textContent = `🧑 プレイヤー: ${wordHira}`;
      log.appendChild(playerEntry);

      inputEl.value = "";
      previousWord = wordHira;
      usedWords.push(wordHira);
      turnCount++;
      updateDisplays();

      // AI 応答
      const lastChar = getValidLastChar(wordHira);
      const candidates = dictionary[lastChar] || [];
      const available = candidates.filter(w => !usedWords.includes(w));

      const aiEntry = document.createElement('div');
      if (available.length === 0) {
        aiEntry.textContent = '🤖 コンピューター: （該当なし）';
        log.appendChild(aiEntry);
        endGame("🤖 コンピューターが詰みました！");
      } else {
        const aiWord = available[getRandomInt(available.length)];
        aiEntry.textContent = `🤖 コンピューター: ${aiWord}`;
        log.appendChild(aiEntry);
        previousWord = aiWord;
        usedWords.push(aiWord);
        turnCount++;
        updateDisplays();
      }
      scrollLogToBottom();
    })
    .catch(err => {
      console.error('辞書読み込みエラー', err);
      alert('辞書の読み込みに失敗しました。');
    });
});
