<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <title>ログイン - しりとりバトル</title>
  <script src="login.js"></script>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      padding: 40px;
      background: #f0f0f0;
    }
    input, button {
      margin: 10px;
      padding: 10px;
      font-size: 16px;
      width: 250px;
    }
    .error {
      color: red;
    }
  </style>
</head>
<body>
  <h1>ログイン</h1>

  <input type="text" id="userId" placeholder="ユーザーID"><br>
  <input type="password" id="password" placeholder="パスワード"><br>
  <button onclick="login()">ログイン</button>

  <p class="error" id="errorMsg"></p>

  <!-- ✅ 新規登録へのリンクを追加 -->
  <p><a href="register.html">新規登録はこちら</a></p>
</body>
</html>
