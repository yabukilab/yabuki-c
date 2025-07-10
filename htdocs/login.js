async function login() {
  const id = document.getElementById('userId').value.trim();
  const pw = document.getElementById('password').value;
  const errorMsg = document.getElementById('errorMsg');

  if (!id || !pw) {
    errorMsg.textContent = 'IDとパスワードを入力してください。';
    return;
  }

  const res = await fetch("index.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username: id, password: pw })
  });

  const result = await res.json();

  if (result.success) {
    window.location.href = "menu.html"; // ✅ ここでリダイレクト
  } else {
    errorMsg.textContent = result.error || "ログインに失敗しました";
  }
}
