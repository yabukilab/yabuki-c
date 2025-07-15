<?php
session_start();
require "db.php";
$pdo = $db;

$userid = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER["CONTENT_TYPE"] ?? "", "application/json") !== false) {
    header("Content-Type: application/json");
    $input = json_decode(file_get_contents("php://input"), true);

    $userid = $input["username"] ?? "";
    $password = $input["password"] ?? "";

    if (!$userid || !$password) {
        echo json_encode(["success" => false, "error" => "ユーザーIDとパスワードを入力してください"]);
        exit();
    }

    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$userid]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "IDまたはパスワードが正しくありません"]);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ログイン</title>
  <link rel="stylesheet" href="newuserstyle.css" />

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
  <div class="container">
    <h2>ログイン</h2>
    <input type="text" id="userId" placeholder="ID" required value="<?= htmlspecialchars($userid) ?>" />
    <input type="password" id="password" placeholder="パスワード" required />
    <div id="errorMsg" class="error"><?= htmlspecialchars($error) ?></div>
    <button onclick="login()">ログインする</button>
    <p><a href="register.php">新規登録はこちら</a></p>
  </div>

  <script>
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
      window.location.href = "menu.php";
    } else {
      errorMsg.textContent = result.error || "ログインに失敗しました";
    }
  }
  </script>

  <!-- 絵文字背景 -->
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
