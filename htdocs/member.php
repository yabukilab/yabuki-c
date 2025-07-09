<?php
// member.php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <title>メンバーページ</title>
</head>
<body>
  <h1><?php echo htmlspecialchars($username); ?> さん、ようこそ！</h1>
  <p><a href="logout.php">ログアウト</a></p>
</body>
</html>