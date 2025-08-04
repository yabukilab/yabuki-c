<?php
require 'db.php';

$stmt = $pdo->query("
    SELECT u.username, s.score, s.play_time, s.played_at
    FROM scores s
    JOIN users u ON s.user_id = u.id
    ORDER BY s.score ASC, s.played_at ASC
    LIMIT 10
");
$rankings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>全体ランキング</h2>
<table border="1">
    <tr><th>順位</th><th>ユーザー名</th><th>スコア</th><th>時間</th><th>日時</th></tr>
    <?php foreach ($rankings as $i => $r): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($r['username']) ?></td>
            <td><?= htmlspecialchars($r['score']) ?></td>
            <td><?= htmlspecialchars($r['play_time']) ?></td>
            <td><?= htmlspecialchars($r['played_at']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>


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
