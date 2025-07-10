<?php
session_start();
require "db.php";
$pdo = $db;

$userid = "";
$error = "";

// ✅ JavaScriptからのPOST（JSON）だった場合：APIレスポンス
if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER["CONTENT_TYPE"] ?? "", "application/json") !== false) {
    header("Content-Type: application/json");
    $input = json_decode(file_get_contents("php://input"), true);

    $userid = $input["username"] ?? "";
    $password = $input["password"] ?? "";

    if (!$userid || !$password) {
        echo json_encode(["success" => false, "error" => "ユーザーIDとパスワードを入力してください"]);
        exit();
    }

    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$userid]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "IDまたはパスワードが正しくありません"]);
    }
    exit();
    echo "<script>localStorage.setItem('user_id', {$user['id']});</script>";

}

// ✅ HTML画面表示（GETアクセスの場合）
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <title>ログイン - しりとりバトル</title>
  <script src="login.js"></script>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      padding: 40px;
      background: #f0f0f0;
    }
    input, button {
      margin: 10px;
      padding: 10px;
      font-size: 16px;
      width: 250px;
    }
    .error { color: red; }
  </style>
</head>
<body>
  <h1>ログイン</h1>
  <input type="text" id="userId" placeholder="ユーザーID"><br>
  <input type="password" id="password" placeholder="パスワード"><br>
  <button onclick="login()">ログイン</button>
  <p class="error" id="errorMsg"></p>
  <p><a href="register.php">新規登録</a></p>
</body>
</html>
