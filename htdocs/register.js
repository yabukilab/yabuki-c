function register() {
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

  const users = JSON.parse(localStorage.getItem('users')) || {};
  if (users[id]) {
    error.textContent = "このユーザーIDはすでに使用されています。";
    return;
  }

  users[id] = pw;
  localStorage.setItem('users', JSON.stringify(users));
  success.textContent = "登録が完了しました。ログイン画面に戻ってログインしてください。";
}
