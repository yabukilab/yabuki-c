<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

// 受け取ったJSONを解析
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// DB接続情報
$host = 'localhost';
$port = '3306';
$db   = 'mydb';
$user = 'testuser';
$pass = 'pass';

try {
  $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);

  // ユーザー名で検索
  $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $username;
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "error" => "IDまたはパスワードが正しくありません"]);
  }
} catch (PDOException $e) {
  echo json_encode(["success" => false, "error" => "接続エラー: " . $e->getMessage()]);
}
