<?php
session_start();
$error = "";
$userid = "";

require "db.php" ;
$pdo=$db;


// POSTで送信されたとき
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid = $_POST["userid"] ?? "";
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$userid]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        // セッション保存
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        // 成功 → メニュー画面へ
        header("Location: menu.html");
        exit();
    } else {
        $error = "※IDまたはパスワードが正しくありません";
    }
}
?>

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
    .error { color: red; }

   html, body {
          height: 100%;
      margin: 0;
      font-family: 'Kosugi Maru', sans-serif;
      background: linear-gradient(to bottom right, #ffe0f0, #e0f7fa);
      overflow: hidden;
      position: relative;
    }

    .emoji {
      position: absolute;
      font-size: 50px;
      opacity: 0.12;
      pointer-events: none;
      animation: float 10s infinite ease-in-out alternate;
    }
  </style>
</head>
<body>
  <h1>ログイン</h1>
  <input type="text" id="userId" placeholder="ユーザーID"><br>
  <input type="password" id="password" placeholder="パスワード"><br>
  <button onclick="login()">ログイン</button>
  <p class="error" id="errorMsg"></p>
      <p><a href="register.php">新規登録はこちら</a></p>

       <!-- バラバラに配置された絵文字たち -->
  <div class="emoji" style="top: 10%; left: 15%;">🍎</div>
  <div class="emoji" style="top: 20%; left: 70%;">🦍</div>
  <div class="emoji" style="top: 35%; left: 40%;">📯</div>
  <div class="emoji" style="top: 55%; left: 80%;">🐱</div>
  <div class="emoji" style="top: 65%; left: 25%;">📦</div>
  <div class="emoji" style="top: 75%; left: 50%;">🍙</div>
  <div class="emoji" style="top: 5%;  left: 80%;">🐰</div>
  <div class="emoji" style="top: 50%; left: 10%;">🦊</div>
  <div class="emoji" style="top: 85%; left: 60%;">🪿</div>
  <div class="emoji" style="top: 30%; left: 90%;">🧃</div>
  <div class="emoji" style="top: 40%; left: 5%;">🍓</div>
  <div class="emoji" style="top: 15%; left: 55%;">🐘</div>
  <div class="emoji" style="top: 70%; left: 35%;">🎈</div>
  <div class="emoji" style="top: 90%; left: 20%;">🧸</div>

</body>

  <footer>© 2025 yabuki lab</footer>
</html>
