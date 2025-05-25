document.getElementById('submitBtn').addEventListener('click', () => {
  const input = document.getElementById('playerInput');
  const word = input.value.trim();

  if (word === "") return;

  const log = document.getElementById('log');
  const entry = document.createElement('div');
  entry.textContent = `🧑 プレイヤー: ${word}`;
  log.appendChild(entry);

  input.value = "";
});
