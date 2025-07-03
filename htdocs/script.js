// カタカナ→ひらがな変換関数
function katakanaToHiragana(str) {
  return str.replace(/[ァ-ヶー]/g, ch =>
    String.fromCharCode(ch.charCodeAt(0) - 0x60)
  );
}

let remainingTime = 60;
let gameInterval = null;
let turnCount = 0;
let gameEnded = false;
let currentUser = localStorage.getItem('currentUser') || "guest";
let previousWord = null;

function saveScore(score) {
  if (!currentUser) return;
  const key = `scores_${currentUser}`;
  const scores = JSON.parse(localStorage.getItem(key)) || [];
  scores.push(score);
  scores.sort((a, b) => b - a);
  localStorage.setItem(key, JSON.stringify(scores.slice(0, 10)));
}

function updateDisplays() {
  document.getElementById('timer').textContent = `残り時間: ${remainingTime}秒`;
  document.getElementById('turnCount').textContent = `ターン数: ${turnCount}`;
}

function startTimer() {
  updateDisplays();
  gameInterval = setInterval(() => {
    if (remainingTime <= 0) {
      clearInterval(gameInterval);
      gameEnded = true;
      document.getElementById('playerInput').disabled = true;
      document.getElementById('submitBtn').disabled = true;
      document.getElementById('restartBtn').style.display = 'inline-block';
      document.getElementById('menuBtn').style.display = 'inline-block';
      document.getElementById('scoreBtn').style.display = 'inline-block';
      saveScore(turnCount);
      const log = document.getElementById('log');
      const endMessage = document.createElement('div');
      endMessage.textContent = `⏰ 制限時間終了！合計ターン数: ${turnCount}`;
      log.appendChild(endMessage);
      return;
    }
    remainingTime--;
    updateDisplays();
  }, 1000);
}

function resetGame() {
  clearInterval(gameInterval);
  remainingTime = 60;
  turnCount = 0;
  gameEnded = false;
  previousWord = null;
  document.getElementById('log').innerHTML = "";
  document.getElementById('playerInput').disabled = false;
  document.getElementById('submitBtn').disabled = false;
  document.getElementById('playerInput').value = "";
  document.getElementById('restartBtn').style.display = 'none';
  document.getElementById('menuBtn').style.display = 'none';
  document.getElementById('scoreBtn').style.display = 'none';
  updateDisplays();
  startTimer();
}

function getUsedWords() {
  const log = document.getElementById('log');
  return Array.from(log.children).map(div => div.textContent.split(': ')[1]);
}

document.addEventListener('DOMContentLoaded', () => {
  startTimer();

  document.getElementById('restartBtn').addEventListener('click', resetGame);
  document.getElementById('scoreBtn').addEventListener('click', () => {
    location.href = 'score.html';
  });
  document.getElementById('menuBtn').addEventListener('click', () => {
    location.href = 'menu.html';
  });
});

document.getElementById('submitBtn').addEventListener('click', () => {
  if (gameEnded) return;

  const input = document.getElementById('playerInput');
  const word = input.value.trim();
  if (word === "") return;

  fetch('./data/words_large_corrected.json')
    .then(response => response.json())
    .then(dictionary => {
      const wordHiragana = katakanaToHiragana(word);

      const allWords = Object.values(dictionary).flat();
      if (!allWords.includes(wordHiragana)) {
        alert("❌ この単語は辞書に登録されていません。");
        return;
      }

      const usedWords = getUsedWords();
      if (usedWords.includes(wordHiragana)) {
        alert("❌ この単語はすでに使われています。");
        return;
      }

      if (previousWord) {
        const prevLast = katakanaToHiragana(previousWord.slice(-1));
        const currFirst = wordHiragana[0];
        if (prevLast !== currFirst) {
          alert(`❌ 前の単語は「${previousWord}」です。頭文字「${prevLast}」で始まる単語を入力してください。`);
          return;
        }
      }

      const log = document.getElementById('log');
      const entry = document.createElement('div');
      entry.textContent = `🧑 プレイヤー: ${wordHiragana}`;
      log.appendChild(entry);
      input.value = "";
      previousWord = wordHiragana;

      const lastChar = wordHiragana.slice(-1);
      const candidates = dictionary[lastChar] || [];
      const available = candidates.filter(w => !usedWords.includes(w));

      const aiEntry = document.createElement('div');
      if (available.length === 0) {
        aiEntry.textContent = '🤖 コンピューター: （該当なし）';
      } else {
        const aiWord = available[Math.floor(Math.random() * available.length)];
        aiEntry.textContent = `🤖 コンピューター: ${aiWord}`;
        previousWord = aiWord;
        turnCount++;
        updateDisplays();
      }
      log.appendChild(aiEntry);
    });
});