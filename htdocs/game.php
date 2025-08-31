<?php
session_start();

// ログイン済みならユーザー情報を渡す（PHP変数として保持するだけ）
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "guest";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>しりとりゲーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>しりとりゲーム</h1>

    <!-- ゲーム情報 -->
    <div id="status">
        <span id="timer">残り時間: 60秒</span>　
        <span id="turnCount">ターン数: 0</span>
    </div>

    <!-- ゲームログ -->
    <div id="log" style="border:1px solid #ccc; width:500px; height:300px; overflow-y:scroll; margin:10px auto; padding:5px; background:#fff;">
        <!-- プレイ中の会話ログがここに追加される -->
    </div>

    <!-- 入力フォーム -->
    <div id="controls" style="margin-top:10px;">
        <input type="text" id="playerInput" placeholder="単語を入力" autofocus>
        <button id="submitBtn">送信</button>
    </div>

    <!-- 操作ボタン -->
    <div id="actions" style="margin-top:20px;">
        <button id="restartBtn" style="display:none;">🔄 もう一度</button>
        <button id="menuBtn" style="display:none;" onclick="location.href='menu.php'">🏠 メニューへ</button>
        <button id="scoreBtn" style="display:none;" onclick="location.href='show-score.php'">📊 スコアを見る</button>
    </div>

    <!-- ★ ここでは localStorage を上書きしない -->
    <!-- menu.php で保存済みの user_id / currentUser をそのまま利用する -->

    <!-- ゲーム用スクリプト -->
    <script src="script.js"></script>
</body>
</html>
