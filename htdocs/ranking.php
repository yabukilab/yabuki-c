<?php
require 'db.php';

# 全ユーザーの履歴ベースでTOP10を取得
# スコアが高い順、同スコアならタイムが短い順、さらに同一なら日時が古い順
$stmt = $pdo->query("
    SELECT u.username, s.score, s.play_time, s.played_at
    FROM score s
    JOIN users u ON s.user_id = u.id
    ORDER BY s.score DESC, s.play_time ASC, s.played_at ASC
    LIMIT 10
");
$rankings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>全体ランキング</title>
    <style>
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;">🏆 全体ランキング TOP10</h1>
    <table>
        <thead>
            <tr>
                <th>順位</th>
                <th>ユーザー名</th>
                <th>スコア</th>
                <th>タイム（秒）</th>
                <th>日時</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rankings as $index => $row): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['score']) ?></td>
                    <td><?= htmlspecialchars($row['play_time']) ?>秒</td>
                    <td><?= htmlspecialchars($row['played_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
