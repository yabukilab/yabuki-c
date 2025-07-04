async function register() {
  const id = document.getElementById('newId').value.trim();
  const pw = document.getElementById('newPassword').value;
  const pwConfirm = document.getElementById('confirmPassword').value;
  const error = document.getElementById('errorMsg');
  const success = document.getElementById('successMsg');
  error.textContent = "";
  success.textContent = "";

  if (!id || !pw || !pwConfirm) {
    error.textContent = "全ての項目を入力してください。";
    return;
  }
  if (pw !== pwConfirm) {
    error.textContent = "パスワードが一致しません。";
    return;
  }

  const res = await fetch("register.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username: id, password: pw })
  });
  const result = await res.json();

  if (result.success) {
    success.textContent = "登録に成功しました。ログインしてください。";
  } else {
    error.textContent = result.error;
  }
}
