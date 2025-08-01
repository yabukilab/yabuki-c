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
    <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Kosugi Maru', sans-serif;
      background: linear-gradient(to bottom right, #ffe0f0, #e0f7fa);
      overflow: hidden;
      position: relative;
    }

    .emoji {
      position: absolute;
      font-size: 50px;
      opacity: 0.12;
      pointer-events: none;
      animation: float 10s infinite ease-in-out alternate;
    }

    @keyframes float {
      0%   { transform: translateY(0); }
      100% { transform: translateY(-20px); }
    }

    .container {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      z-index: 10;
    }

    h1 {
      font-size: 40px;
      color: #ff4081;
      margin-bottom: 40px;
      text-shadow: 2px 2px 0 #fff;
    }

    .menu-button {
      display: block;
      width: 260px;
      margin: 20px auto;
      padding: 15px 25px;
      font-size: 20px;
      background: linear-gradient(145deg, #ff8a80, #ff5252);
      border: none;
      border-radius: 20px;
      color: white;
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .menu-button:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }
  </style>
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

    <button class="menu-button" onclick="location.href='game.php'">▶ ゲーム開始</button>
    <button class="menu-button" onclick="location.href='user_scores.php'">▶ 成績を見る</button>
    <button class="menu-button" onclick="location.href='ranking.php'">▶ ランキング</button> 

  </div>
  </body>
