function login() {
  const id = document.getElementById('userId').value.trim();
  const pw = document.getElementById('password').value;

  if (!id || !pw) {
    document.getElementById('errorMsg').textContent = 'IDとパスワードを入力してください。';
    return;
  }

  const users = JSON.parse(localStorage.getItem('users')) || {};

  if (!users[id]) {
    document.getElementById('errorMsg').textContent = 'このユーザーIDは登録されていません。';
    return;
  }

  if (users[id] !== pw) {
    document.getElementById('errorMsg').textContent = 'パスワードが一致しません。';
    return;
  }

  // ログイン成功：ユーザーIDを記憶してメニューへ
  localStorage.setItem('currentUser', id);
  location.href = 'menu.html';
}
