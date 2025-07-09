<?php
header("Content-Type: application/json; charset=UTF-8");

// JSONデータを取得
$data = json_decode(file_get_contents("php://input"), true);

require "db.php" ;

  // 必須チェック
  if (!isset($data['user_id']) || !isset($data['score'])) {
    echo json_encode(["success" => false, "error" => "必要なデータが不足しています"]);
    exit;
  }

  // スコア登録
  $stmt = $pdo->prepare("INSERT INTO game_records (user_id, score, play_time) VALUES (?, ?, ?)");
  $stmt->execute([
    $data['user_id'],
    $data['score'],
    $data['play_time'] ?? null
  ]);

  echo json_encode(["success" => true]);
} catch (PDOException $e) {
  echo json_encode(["success" => false, "error" => "データベースエラー：" . $e->getMessage()]);
}
?>
