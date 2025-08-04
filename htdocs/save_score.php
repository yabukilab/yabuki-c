<?php
header('Content-Type: application/json');
require 'db.php';
session_start();

$user_id = $_POST['user_id'] ?? null;
$score = $_POST['score'] ?? null;
$play_time = $_POST['play_time'] ?? null;

if ($user_id && $score && $play_time) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO score (user_id, score, play_time)
            VALUES (:user_id, :score, :play_time)
            ON DUPLICATE KEY UPDATE played_at = CURRENT_TIMESTAMP
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':score' => $score,
            ':play_time' => $play_time,
        ]);
        echo json_encode(['status' => 'success', 'message' => '✅ 保存成功']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => '❌ 保存失敗：DBエラー', 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => '❌ データ不足']);
}
