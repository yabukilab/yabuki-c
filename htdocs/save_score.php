<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

require "db.php";
$pdo = $db;

// JSONを受け取る
$data = json_decode(file_get_contents("php://input"), true);

// バリデーション
if (
    !isset($data["user_id"]) ||
    !isset($data["score"]) ||
    !isset($data["play_time"])
) {
    echo json_encode(["success" => false, "error" => "ユーザーIDまたはスコアが不足しています"]);
    exit();
}

$user_id   = (int)$data["user_id"];
$score     = (int)$data["score"];
$play_time = (float)$data["play_time"];
$now       = date("Y-m-d H:i:s");

try {
    // ユーザーのベストスコアを取得
    $stmt = $pdo->prepare("SELECT best_score FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(["success" => false, "error" => "ユーザーが存在しません"]);
        exit();
    }

    // ベストスコア更新判定
    if ($user["best_score"] === null || $score > (int)$user["best_score"]) {
        $upd = $pdo->prepare("
            UPDATE users
            SET best_score = ?,
                best_score_duration = ?,
                best_score_time = ?
            WHERE id = ?
        ");
        $upd->execute([$score, $play_time, $now, $user_id]);
    }

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "DBエラー: " . $e->getMessage()]);
}
