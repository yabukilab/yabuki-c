<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

require "db.php"; // PDO接続用の $db を含む
$pdo = $db;

// JSONデータ受信
$data = json_decode(file_get_contents("php://input"), true);

// 必要なデータの存在確認
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
  // 該当ユーザーが存在するか確認
  $stmt = $pdo->prepare("SELECT best_score FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    echo json_encode(["success" => false, "error" => "ユーザーが存在しません"]);
    exit();
  }

  // スコア保存（game_records テーブルにも残したい場合はここで INSERT）

  // ベストスコア更新が必要かチェック
  if ($user["best_score"] === null || $score > $user["best_score"]) {
    $update = $pdo->prepare("UPDATE users SET best_score = ?, best_time = ?, best_datetime = ? WHERE id = ?");
    $update->execute([$score, $play_time, $now, $user_id]);
  }

  echo json_encode(["success" => true]);
} catch (PDOException $e) {
  echo json_encode(["success" => false, "error" => "DBエラー: " . $e->getMessage()]);
}
