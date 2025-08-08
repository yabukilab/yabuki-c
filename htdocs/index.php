<?php
# セッションを開始（ログイン情報などを保持するため）
session_start();

# データベース接続ファイルを読み込み
require "db.php";
$pdo = $db;

# 初期化
$userid = "";
$error = "";

# JSON形式のPOSTリクエスト（JavaScript経由のログイン処理）かどうか判定
if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER["CONTENT_TYPE"] ?? "", "application/json") !== false) {
    header("Content-Type: application/json");

    # フロントエンドから受け取ったJSONを連想配列として取得
    $input = json_decode(file_get_contents("php://input"), true);

    # ユーザー入力の取得
    $userid = $input["username"] ?? "";
    $password = $input["password"] ?? "";

    # 入力チェック
    if (!$userid || !$password) {
        echo json_encode(["success" => false, "error" => "ユーザーIDとパスワードを入力してください"]);
        exit();
    }

    # 入力されたユーザーIDに該当するユーザー情報をDBから取得
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$userid]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    # パスワードが正しければログイン成功、セッションに情報を保存
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        echo json_encode(["success" => true]);
    } else {
        # 認証失敗時
        echo json_encode(["success" => false, "error" => "IDまたはパスワードが正しくありません"]);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ログイン</title>

  # 外部CSSファイル（見た目を整える）
  <link rel="stylesheet" href="newuserstyle.css" />

  <style>
    # ページ全体のスタイル設定（背景・フォントなど）
    body {
      font-family: 'Kosugi Maru', sans-serif;
      text-align: center;
      padding: 40px;
      background: linear-gradient(to bottom right, #ffe0f0, #e0f7fa);
      margin: 0;
      overflow: hidden;
    }

    # 入力欄とボタンのスタイル
    input, button {
      margin: 10px;
      padding: 10px;
      font-size: 16px;
      width: 250px;
    }

    .error { color: red; }

    # 背景の絵文字用スタイル
    .emoji {
      position: absolute;
      font-size: 50px;
      opacity: 0.12;
      pointer-events: none;
      animation: float 10s infinite ease-in-out alternate;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>ログイン</h2>

    # ユーザーIDとパスワード入力欄
    <input type="text" id="userId" placeholder="ID" required value="<?= htmlspecialchars($userid) ?>" />
    <input type="password" id="password" placeholder="パスワード" required />

    # エラー表示用欄
    <div id="errorMsg" class="error"><?= htmlspecialchars($error) ?></div>

    # ログインボタン（クリック時にJSのlogin関数を呼ぶ）
    <button onclick="login()">ログインする</button>

    <p><a href="register.php">新規登録はこちら</a></p>
  </div>

  <script>
  // JavaScriptによるログイン処理（jsファイルを使わずここに直接記述）

  async function login() {
    // ユーザー入力の取得
    const id = document.getElementById('userId').value.trim();
    const pw = document.getElementById('password').value;
    const errorMsg = document.getElementById('errorMsg');

    // 入力チェック
    if (!id || !pw) {
      errorMsg.textContent = 'IDとパスワードを入力してください。';
      return;
    }

    try {
      // 非同期通信でindex.phpにJSON形式でデータ送信
      const res = await fetch("index.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username: id, password: pw })
      });

      const result = await res.json();

      // 成功ならメニュー画面にリダイレクト
      if (result.success) {
        window.location.href = "menu.php";
      } else {
        errorMsg.textContent = result.error || "ログインに失敗しました";
      }
    } catch (e) {
      errorMsg.textContent = "通信エラーが発生しました";
    }
  }
  </script>

  # 絵文字背景（ただの演出です）
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

  <footer>© 2025 yabuki lab</footer>
</body>
</html>
