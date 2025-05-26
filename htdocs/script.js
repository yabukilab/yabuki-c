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
      const lastChar = word[word.length - 1];
      const candidates = dictionary[lastChar] || [];
      const usedWords = Array.from(log.children).map(div => div.textContent.split(": ")[1]);

      // 使用済みを除外し、五十音順にソートして優先度を明確化
      const available = candidates
        .filter(w => !usedWords.includes(w))
        .sort((a, b) => a.localeCompare(b, 'ja')); // 五十音順

      if (available.length === 0) {
        const aiEntry = document.createElement('div');
        aiEntry.textContent = '🤖 コンピューター: （該当なし）';
        log.appendChild(aiEntry);
        return;
      }

      const aiWord = available[0]; // 優先度トップの単語を選択
      const aiEntry = document.createElement('div');
      aiEntry.textContent = `🤖 コンピューター: ${aiWord}`;
      log.appendChild(aiEntry);
    });
});
