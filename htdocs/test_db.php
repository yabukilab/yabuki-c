<?php
$host = '127.0.0.1';
$db   = 'shiritori';
$user = 'testuser';
$pass = 'pass';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
  echo "✅ 接続成功しました！";
} catch (PDOException $e) {
  echo "❌ 接続失敗: " . $e->getMessage();
}
?>
