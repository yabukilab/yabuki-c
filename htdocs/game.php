<?php
session_start();
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["username"])) {
  header("Location: index.php");
  exit();
}
$userId = $_SESSION["user_id"];
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>しりとりバトル</title>
  <link rel="stylesheet" href="style.css">
  <script>
    localStorage.setItem("user_id", <?= json_encode($userId) ?>);
    localStorage.setItem("currentUser", <?= json_encode($username) ?>);
  </script>
</head>
<body>
  <h1>しりとりバトル</h1>

  <div id="game-area">
    <div id="timer">残り時間: 60秒</div>
    <div id="turnCount">ターン数: 0</div>
    <div id="log"></div>
    <input type="text" id="playerInput" placeholder="単語を入力してください">
    <button id="submitBtn">送信</button>
    <button id="restartBtn" style="display: none;">リスタート</button>
    <button id="menuBtn" style="display: none;" onclick="location.href='menu.php'">メニュー</button>
    <button id="scoreBtn" style="display: none;" onclick="location.href='user_scores.php'">成績</button>
    <button id="scoreBtn" style="display: none;" onclick="location.href='ranking.php'">ランキング</button>
  </div>

  <script src="script.js"></script>

  <script>
  function saveScore(userId, score, time) {
    const scoreData = {
      user_id: userId,
      score: score,
      play_time: time
    };

    fetch("save_score.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(scoreData)
    })
    .then(res => res.json())
    .then(result => {
      if (result.success) {
        alert("スコア保存完了！");
      } else {
        alert("保存失敗：" + result.error);
      }
    });
  }

  function endGame() {
    clearInterval(timerId);
    document.getElementById("restartBtn").style.display = "inline-block";
    document.getElementById("menuBtn").style.display = "inline-block";
    document.getElementById("scoreBtn").style.display = "inline-block";
    logMessage("ゲーム終了！");

    const score = turnCount;
    const timeTaken = 60 - timeLeft;
    const user_Id = localStorage.getItem("user_id");

    saveScore(user_Id, score, timeTaken);
  }
  </script>

</body>
</html>
