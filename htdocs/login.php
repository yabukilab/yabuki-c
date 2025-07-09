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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ログイン</title>
  <link rel="stylesheet" href="newuserstyle.css" />
</head>
<body>
  <div class="container">
    <h2>ログイン</h2>
    <form action="login.php" method="post">
      <input type="text" name="userid" placeholder="ID" required value="<?= htmlspecialchars($userid) ?>" />
      <input type="password" name="password" placeholder="パスワード" required />
      <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <button type="submit">ログイン</button>
    </form>
    <p><a href="register.html">新規登録はこちら</a></p>
  </div>
  <footer>© 2025 yabuki lab</footer>
</body>
</html>
