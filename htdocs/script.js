// カタカナ→ひらがな変換関数
function katakanaToHiragana(str) {
  return str.replace(/[ァ-ヶ]/g, ch =>
    String.fromCharCode(ch.charCodeAt(0) - 0x60)
  );
}

document.getElementById('submitBtn').addEventListener('click', () => {
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
      const lastChar = katakanaToHiragana(rawLastChar);  // ← ここで正規化

      const candidates = dictionary[lastChar] || [];
      const usedWords = Array.from(log.children).map(div => div.textContent.split(": ")[1]);

      // 使用済みを除外して五十音順で優先度付け
      const available = candidates
        .filter(w => !usedWords.includes(w))
        .sort((a, b) => a.localeCompare(b, 'ja'));

      const aiEntry = document.createElement('div');
      if (available.length === 0) {
        aiEntry.textContent = '🤖 コンピューター: （該当なし）';
      } else {
        const aiWord = available[0];
        aiEntry.textContent = `🤖 コンピューター: ${aiWord}`;
      }
      log.appendChild(aiEntry);
    });
});
