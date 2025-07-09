<?php
// register.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (!$username || !$password) {
    $message = "ユーザー名とパスワードを入力してください。";
  } else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $host = '127.0.0.1';
    $db   = 'mydb';
    $user = 'testuser';
    $pass = 'pass';
    $dsn  = "mysql:host=$host;dbname=$db;charset=utf8";

    try {
      $pdo = new PDO($dsn, $user, $pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)");
      $stmt->execute([$username, $hashed]);
      $message = "登録が完了しました。ログインしてください。";
    } catch (PDOException $e) {
      $message = "エラー: " . htmlspecialchars($e->getMessage());
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規登録</title>
</head>
<body>
  <h1>ユーザー登録</h1>
  <?php if (!empty($message)) echo '<p>' . htmlspecialchars($message) . '</p>'; ?>
  <form method="post" action="register.php">
    <label>ユーザー名: <input type="text" name="username" required></label><br><br>
    <label>パスワード: <input type="password" name="password" required></label><br><br>
    <button type="submit">登録</button>
  </form>
  <p><a href="login.php">ログインへ戻る</a></p>
</body>
</html>
