<?php
header("Content-Type: application/json; charset=UTF-8");

$host = 'localhost';
$db   = 'shiritori';
$user = 'root';
$pass = 'your_password'; // ←あなたのMySQLパスワードに変更

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
  $sql = "SELECT users.username, game_records.score, game_records.play_date 
          FROM game_records 
          JOIN users ON game_records.user_id = users.id 
          ORDER BY game_records.score DESC 
          LIMIT 10";
  $stmt = $pdo->query($sql);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($result);
} catch (PDOException $e) {
  echo json_encode([]);
}
?>
