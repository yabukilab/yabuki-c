<?php
session_start();
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["username"])) {
    header("Location: index.php"); // ログインページにリダイレクト
    exit();
}
$userId = $_SESSION["user_id"];
$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>メニュー画面</title>
  <link rel="stylesheet" href="style.css" />
  <script>
    // ✅ ログインユーザー情報をlocalStorageに保存
    localStorage.setItem("user_id", <?= json_encode($userId) ?>);
    localStorage.setItem("currentUser", <?= json_encode($username) ?>);
  </script>
</head>
<body>
  <div class="container">
    <h1>しりとりバトル メニュー</h1>
    <p>ようこそ、<strong><?= htmlspecialchars($username) ?></strong> さん！</p>

    <ul>
      <li><a href="game.html">▶ ゲームを開始</a></li>
      <li><a href="score.html">📊 成績を見る</a></li>
      <li><a href="
