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
}

// ✅ HTML画面表示（GETアクセスの場合）
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
    <form onsubmit="login(); return false;">
      <input type="text" id="userId" placeholder="ID" required />
      <input type="password" id="password" placeholder="パスワード" required />
      <div id="errorMsg" class="error"><?= htmlspecialchars($error) ?></div>
      <button type="submit">ログイン</button>
    </form>
    <p><a href="register.php">新規登録はこちら</a></p>
  </div>
  <footer>© 2025 yabuki lab</footer>

  <script>
  async function login() {
    const id = document.getElementById('userId').value.trim();
    const pw = document.getElementById('password').value;
    const errorMsg = document.getElementById('errorMsg');

    if (!id || !pw) {
      errorMsg.textContent = 'IDとパスワードを入力してください。';
      return;
    }

    const res = await fetch("index.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username: id, password: pw })
    });

    const result = await res.json();

    if (result.success) {
      window.location.href = "menu.php";
    } else {
      errorMsg.textContent = result.error || "ログインに失敗しました";
    }
  }
  </script>
</body>
</html>
