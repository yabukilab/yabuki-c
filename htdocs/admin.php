<?php
// admin.php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
if (empty($_SESSION['admin'])) {
  header('Location: member.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <title>管理者ページ</title>
</head>
<body>
  <h1>管理者専用ページへようこそ</h1>
  <p><a href="logout.php">ログアウト</a></p>
</body>
</html>