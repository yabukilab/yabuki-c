<?php
// logout.php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <title>ログアウト</title>
</head>
<body>
  <p>ログアウトしました。</p>
  <p><a href="login.php">ログインページへ戻る</a></p>
</body>
</html>
