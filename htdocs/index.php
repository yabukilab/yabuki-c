<?php
# セッション開始
session_start();
require "db.php";
$pdo = $db;

# 初期変数
$userid = "";
$password = "";
$error = "";

# フォーム送信時の処理（POSTかつ通常フォーム）
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid = trim($_POST["userid"] ?? "");
    $password = $_POST["password"] ?? "";

    # 入力チェック
    if (empty($userid) || empty($password)) {
        $error = "※ユーザーIDとパスワードを入力してください";
    } else {
        # DBからユーザー検索
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$userid]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        # パスワード検証
        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: menu.php"); // ✅ 成功時はメニューへ
            exit();
        } else {
            $error = "※IDまたはパスワードが正しくありません";
        }
    }
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
    /* # CSS全般（registerと統一） */
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

    <!-- # 入力フォーム -->
    <form action="index.php" method="post">
      <input type="text" name="userid" placeholder="ID" required value="<?= htmlspecialchars($userid) ?>" />
      <input type="password" name="password" placeholder="パスワード" required />
      <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <button type="submit">ログインする</button>
    </form>

    <!-- # 登録画面へのリンク -->
    <p><a href="register.php">新規登録はこちら</a></p>
  </div>

  <!-- # 絵文字背景 -->
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
