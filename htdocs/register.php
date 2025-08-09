<?php
# セッション開始
session_start();
$message = "";
$userid = "";

# データベース接続ファイル読み込み
require "db.php";
$pdo = $db;

# フォーム送信時の処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid = trim($_POST["userid"] ?? "");
    $password = $_POST["password"] ?? "";

    # 入力チェック
    if (empty($userid) || empty($password)) {
        $message = "※すべての項目を入力してください";
    } elseif (strlen($password) < 6) {
        $message = "※パスワードは6文字以上にしてください";
    } else {
        # ユーザーIDの重複確認
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$userid]);

        if ($stmt->fetch()) {
            $message = "※このユーザーIDは既に使われています";
        } else {
            # パスワードをハッシュ化してDB登録
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)");
            $stmt->execute([$userid, $hashed]);

            # mydb.sqlにINSERT文を追記
            $escapedUser = addslashes($userid);
            $escapedHash = addslashes($hashed);
            $sqlLine = "INSERT INTO users (username, password, is_admin) VALUES ('$escapedUser', '$escapedHash', 0);\n";
            file_put_contents("mydb.sql", $sqlLine, FILE_APPEND | LOCK_EX);

            # 成功時はログイン画面にリダイレクト
            header("Location: index.php?register=success");
            exit();
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
    /* # フォーム・背景の基本デザイン */
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Kosugi Maru', sans-serif;
      background: linear-gradient(to bottom right, #ffe0f0, #e0f7fa);
      overflow: hidden;
      position: relative;
      text-align: center;
      padding: 40px;
    }
    input, button {
      margin: 10px;
      padding: 10px;
      font-size: 16px;
      width: 250px;
    }
    .error { color: red; }

    /* # 背景用の絵文字装飾 */
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
    <h2>新規登録</h2>

    <!-- # 登録フォーム -->
    <form action="register.php" method="post">
      <input type="text" name="userid" placeholder="ID" required value="<?= htmlspecialchars($userid) ?>" />
      <input type="password" name="password" placeholder="パスワード（6文字以上）" required />
      <?php if (!empty($message)): ?>
        <div class="error"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>
      <button type="submit">登録する</button>
    </form>

    <!-- # ログイン画面へのリンク -->
    <p><a href="index.php">ログイン画面に戻る</a></p>
  </div>

  <!-- # 絵文字背景（演出） -->
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

  <!-- # フッター -->
  <footer>© 2025 yabuki lab</footer>
</body>
</html>
