// カタカナ→ひらがな変換関数
function katakanaToHiragana(str) {
  return str.replace(/[ァ-ヶ]/g, ch =>
    String.fromCharCode(ch.charCodeAt(0) - 0x60)
  );
}

let remainingTime = 60;
let gameInterval = null;
let turnCount = 0;
let gameEnded = false;
let currentUser = localStorage.getItem('currentUser') || "guest";

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

  const log = document.getElementById('log');
  const entry = document.createElement('div');
  entry.textContent = `🧑 プレイヤー: ${word}`;
  log.appendChild(entry);
  input.value = "";

  fetch('./data/words_custom.json')
    .then(response => response.json())
    .then(dictionary => {
      const rawLastChar = word[word.length - 1];
      const lastChar = katakanaToHiragana(rawLastChar);

      const candidates = dictionary[lastChar] || [];
      const usedWords = Array.from(log.children).map(div => div.textContent.split(": ")[1]);

      const available = candidates
        .filter(w => !usedWords.includes(w))
        .sort((a, b) => a.localeCompare(b, 'ja'));

      const aiEntry = document.createElement('div');
      if (available.length === 0) {
        aiEntry.textContent = '🤖 コンピューター: （該当なし）';
      } else {
        const aiWord = available[0];
        aiEntry.textContent = `🤖 コンピューター: ${aiWord}`;
        turnCount++;
        updateDisplays();
      }
      log.appendChild(aiEntry);
    });
});
