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

  <!-- バラバラに配置された絵文字たち -->
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

  <!-- メニュー本体 -->
  <div class="container">
    <h1>しりとりバトル 🎮 メニュー</h1>
    <button class="menu-button" onclick="location.href='game.html'">▶ ゲーム開始</button>

    <!--- データベースに接続ができなかったため機能凍結
    <button class="menu-button" onclick="location.href='score.html'">▶ 成績を見る</button>
    <button class="menu-button" onclick="location.href='ranking.html'">▶ ランキング</button> -->
  </div>
  </body>
