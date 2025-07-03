<?php
$host = 'localhost';
$db   = 'testuser_db';  // ← ここもあなたのDB名に
$user = 'testuser';
$pass = 'pass';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
  echo "✅ 接続成功！";
} catch (PDOException $e) {
  echo "❌ 接続失敗：" . $e->getMessage();
}
?>
