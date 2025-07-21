<?php
session_start();
require 'db.php'; // DB接続

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'ログインしていません']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("
        SELECT best_score, best_time, best_datetime
        FROM game_records
        WHERE user_id = ?
        ORDER BY best_score DESC, best_time ASC
        LIMIT 10
    ");
    $stmt->execute([$user_id]);
    $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($scores);
} catch (PDOException $e) {
    echo json_encode(['error' => 'DBエラー: ' . $e->getMessage()]);
}
?>
