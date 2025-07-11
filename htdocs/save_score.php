<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

<<<<<<< HEAD
// POSTデータを受け取る
$input = json_decode(file_get_contents("php://input"), true);

// DB接続
require_once "db.php";
$pdo = $db;

// 必須チェック
if (!isset($input['user_id']) || !isset($input['score'])) {
  echo json_encode([
    "success" => false,
    "error" => "ユーザーIDまたはスコアが不足しています"
  ]);
  exit;
}

$user_id = (int)$input['user_id'];
$score = (int)$input['score'];
$play_time = isset($input['play_time']) ? (float)$input['play_time'] : null;

try {
  // スコア履歴保存
  $stmt = $pdo->prepare("INSERT INTO game_records (user_id, score, play_time, play_date) VALUES (?, ?, ?, NOW())");
  $stmt->execute([$user_id, $score, $play_time]);

  // 現在のベストスコアを取得
  $stmt = $pdo->prepare("SELECT best_score FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  $currentBest = $stmt->fetchColumn();

  // ベストスコア未登録 or 新記録なら更新
  if ($currentBest === null || $score > (int)$currentBest) {
    $stmt = $pdo->prepare("UPDATE users SET best_score = ?, best_score_time = NOW(), best_score_duration = ? WHERE id = ?");
    $stmt->execute([$score, $play_time, $user_id]);
  }

  echo json_encode(["success" => true]);
} catch (PDOException $e) {
  echo json_encode([
    "success" => false,
    "error" => "DBエラー：" . $e->getMessage()
  ]);
=======
require "db.php";
$pdo = $db;

// JSONデータを取得
$data = json_decode(file_get_contents("php://input"), true);

// バリデーション
if (
    !isset($data["user_id"]) ||
    !isset($data["score"]) ||
    !isset($data["play_time"])
) {
    echo json_encode([
        "success" => false,
        "error"   => "ユーザーIDまたはスコアが不足しています"
    ]);
    exit();
}

$user_id   = (int)$data["user_id"];
$score     = (int)$data["score"];
$play_time = (float)$data["play_time"];
$now       = date("Y-m-d H:i:s");

try {
    // 現在のベストスコア取得
    $stmt = $pdo->prepare("SELECT best_score FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode([
            "success" => false,
            "error"   => "ユーザーが存在しません"
        ]);
        exit();
    }

    // ベストスコア更新が必要なら
    if ($user["best_score"] === null || $score > (int)$user["best_score"]) {
        $upd = $pdo->prepare("
            UPDATE users
            SET best_score     = :score,
                best_time      = :play_time,
                best_datetime  = :now
            WHERE id = :uid
        ");
        $upd->execute([
            ':score'     => $score,
            ':play_time' => $play_time,
            ':now'       => $now,
            ':uid'       => $user_id
        ]);
    }

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error"   => "DBエラー: " . $e->getMessage()
    ]);
>>>>>>> f2184d0a5f15070340c4ffd7c22a74b3ad676aba
}
