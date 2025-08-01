<?php
session_start();
require_once 'db.php'; // DB接続ファイル

if (!isset($_SESSION['user_id'])) {
    echo "ログインが必要です。";
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT score, time, played_at 
                           FROM game_records 
                           WHERE user_id = :user_id 
                           ORDER BY score DESC, time ASC 
                           LIMIT 10");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "データ取得エラー: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>自分のスコア履歴</title>
</head>
<body>
    <h1>🔖 あなたの過去の上位スコア</h1>
    <table border="1">
        <tr>
            <th>順位</th>
            <th>スコア</th>
            <th>タイム</th>
            <th>プレイ日時</th>
        </tr>
        <?php foreach ($records as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $row['score'] ?></td>
                <td><?= $row['time'] ?>秒</td>
                <td><?= $row['played_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
