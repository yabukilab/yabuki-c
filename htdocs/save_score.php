<?php
# JSON 形式でレスポンスを返す
header('Content-Type: application/json');
require 'db.php';
session_start();

# クライアントから送られてきた値を取得
$user_id   = $_POST['user_id']   ?? null;
$score     = $_POST['score']     ?? null;
$play_time = $_POST['play_time'] ?? null;

# 必要データが揃っているかチェック
if ($user_id && $score && $play_time) {
    try {
        # 履歴ベースで保存するので、毎回新規にINSERTする
        $stmt = $pdo->prepare("
            INSERT INTO score (user_id, score, play_time, played_at)
            VALUES (:user_id, :score, :play_time, NOW())
        ");
        $stmt->execute([
            ':user_id'   => $user_id,
            ':score'     => $score,
            ':play_time' => $play_time,
        ]);

        echo json_encode([
            'status'  => 'success',
            'message' => '✅ スコアを保存しました'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'status'  => 'error',
            'message' => '❌ 保存失敗：データベースエラー',
            'error'   => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => '❌ データ不足（user_id, score, play_time を確認してください）'
    ]);
}
