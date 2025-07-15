<?php
require_once 'db.php';

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

$user_id = (int)$data['user_id'];
$score = (int)$data['score'];
$time = (float)$data['play_time'];

try {
    // 現在のベストを取得
    $stmt = $pdo->prepare("SELECT best_score, best_time FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);

    $update = false;
    if (!$current || is_null($current['best_score'])) {
        $update = true;
    } elseif ($score > $current['best_score']) {
        $update = true;
    } elseif ($score == $current['best_score'] && $time < $current['best_time']) {
        $update = true;
    }

    if ($update) {
        $stmt = $pdo->prepare("UPDATE users SET best_score = ?, best_time = ?, best_datetime = NOW() WHERE id = ?");
        $stmt->execute([$score, $time, $user_id]);
    }

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
