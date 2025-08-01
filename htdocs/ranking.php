<?php
session_start();
require_once 'db.php'; // DB接続用ファイル

try {
    $stmt = $pdo->prepare("SELECT username, best_score, best_time, best_datetime 
                           FROM users 
                           WHERE best_score IS NOT NULL 
                           ORDER BY best_score DESC, best_time ASC 
                           LIMIT 10");
    $stmt->execute();
    $rankings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "データ取得エラー: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>全体ランキング</title>
</head>
<body>
    <h1>🏆 全体ランキング TOP10</h1>
    <table border="1">
        <tr>
            <th>順位</th>
            <th>ユーザー名</th>
            <th>スコア</th>
            <th>タイム</th>
            <th>日時</th>
        </tr>
        <?php foreach ($rankings as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= $row['best_score'] ?></td>
                <td><?= $row['best_time'] ?>秒</td>
                <td><?= $row['best_datetime'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
