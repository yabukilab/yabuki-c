<?php
session_start();
header("Content-Type: application/json");

require_once "db.php";
$pdo = $db;

// JSONで送信されたデータを取得
$data = json_decode(file_get_contents("php://input"), true);

// セッション or データから user_id を取得
$user_id = $_SESSION["user_id"] ?? $data["user_id"] ?? null;
$score = $data["score"] ?? null;
$play_time = $data["play_time"] ?? null;

// バリデーション
if (!$user_id || $score === null || $play_time === null) {
    echo json_encode([
        "success" => false,
        "error" => "ユーザーIDまたはスコアが不足しています"
    ]);
    exit();
}

try {
    // 現在のベストスコアを取得
    $stmt = $pdo->prepare("SELECT best_score FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        throw new Exception("ユーザーが見つかりません");
    }

    $best = $row['best_score'];

    // スコアがベストより高ければ更新
    if ($best === null || $score > $best) {
        $stmt = $pdo->prepare("UPDATE users SET best_score = ?, best_time = ?, best_date = NOW() WHERE id = ?");
        $stmt->execute([$score, $play_time, $user_id]);
    }

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => "保存中にエラーが発生しました: " . $e->getMessage()
    ]);
}
