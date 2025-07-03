<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

// JSON受け取り
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// DB接続設定
$host = 'localhost';
$db   = 'testuser_db';  // ← あなたのDB名に変更済み
$user = 'root';
$pass = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

  // ユーザー名で検索
  $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    // ログイン成功：セッションに保存
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $username;
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "error" => "IDまたはパスワードが正しくありません"]);
  }
} catch (PDOException $e) {
  echo json_encode(["success" => false, "error" => "データベース接続エラー"]);
}
?>
