<?php
session_start();
$message = "";
$userid = "";

require "db.php";   // $db を返す想定
$pdo = $db;

// POST 受け取り
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid = trim($_POST["userid"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($userid) || empty($password)) {
        $message = "※すべての項目を入力してください";
    } elseif (strlen($password) < 6) {
        $message = "※パスワードは6文字以上にしてください";
    } else {
        // 既存ユーザーID確認
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$userid]);

        if ($stmt->fetch()) {
            $message = "※このユーザーIDは既に使われています";
        } else {
            // 新規登録処理
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)");
            $stmt->execute([$userid, $hashed]);

            // ✅ 成功したら通知メッセージを出す
            $message = "✅ 新規登録が完了しました！ログイン画面からログインしてください。";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>新規登録</title>
  <link rel="stylesheet" href="newuserstyle.css" />
  <style>
    html, body {
      height: 100%; margin: 0;
      font-family: 'Kosugi Maru', sans-serif;
      background: linear-gradient(to bottom right, #ffe0f0, #e0f7fa);
      text-align: center; padding: 40px;
      overflow: hidden; /* ←背景絵文字のため */
      position: relative;
    }
    input, button {
      margin: 10px; padding: 10px;
      font-size: 16px; width: 250px;
    }
    .error { color: red; }
    .success { color: green; font-weight: bold; }
    .emoji {
      position: absolute;
      font-size: 50px;
      opacity: 0.12;
      pointer-events: none;
      animation: float 10s infinite ease-in-out alternate;
    }
    @keyframes float {
      from { transform: translateY(0px); }
      to   { transform: translateY(-20px); }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>新規登録</h2>
    <form action="register.php" method="post">
      <input type="text" name="userid" placeholder="ID（6文字以上）" required value="<?= htmlspecialchars($userid) ?>" />
      <input type="password" name="password" placeholder="パスワード（6文字以上）" required />
      <?php if (!empty($message)): ?>
        <div class="<?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
          <?= htmlspecialchars($message) ?>
        </div>
      <?php endif; ?>
      <button type="submit">登録する</button>
    </form>
    <p><a href="index.php">ログイン画面に戻る</a></p>
  </div>

  <!-- 🎨 背景の絵文字 -->
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

  <footer>© 2025 yabuki lab</footer>
</body>
</html>
