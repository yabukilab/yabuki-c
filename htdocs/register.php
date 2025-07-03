<?php
header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

// あなたのMySQL接続情報に合わせて変更！
$host = 'localhost';
$db   = 'siritori';
$user = 'root';
$pass = '';  // ← 実際のパスワードに置き換えてください

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
  $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
  $stmt->execute([$data['username'], $hashed]);
  echo json_encode(["success" => true]);
} catch (PDOException $e) {
  echo json_encode(["success" => false, "error" => "登録に失敗しました"]);
}
?>

