<?php
session_start();
$message = "";
$userid = "";

// DB接続情報
$dbServer = '127.0.0.1';
$dbUser   = $_SERVER['MYSQL_USER']     ?? 'testuser';
$dbPass   = $_SERVER['MYSQL_PASSWORD'] ?? 'pass';
$dbName   = $_SERVER['MYSQL_DB']       ?? 'mydb';
$dsn = "mysql:host=$dbServer;dbname=$dbName;charset=utf8";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続失敗: " . htmlspecialchars($e->getMessage()));
}

// フォーム処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid = trim($_POST["userid"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($userid) || empty($password)) {
        $message = "※すべての項目を入力してください";
    } elseif (strlen($password) < 6) {
        $message = "※パスワードは6文字以上にしてください";
    } else {
        // ユーザー名重複チェック
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$userid]);

        if ($stmt->fetch()) {
            $message = "※このユーザーIDは既に使われています";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)");
            $stmt->execute([$userid, $hashed]);
            header("Location: login.php?register=success");
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
</head>
<body>
  <div class="container">
    <h2>新規登録</h2>
    <form action="register.php" method="post">
      <input type="text" name="userid" placeholder="ID" required value="<?= htmlspecialchars($userid) ?>" />
      <input type="password" name="password" placeholder="パスワード（6文字以上）" required />
      <?php if (!empty($message)): ?>
        <div class="error"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>
      <button type="submit">登録する</button>
    </form>
    <p><a href="login.php">ログイン画面に戻る</a></p>
  </div>
  <footer>© 2025 yabuki lab</footer>
</body>
</html>
