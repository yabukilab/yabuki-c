<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require 'db.php';
$userId = $_SESSION['user_id'];

# ログイン中ユーザーのスコア履歴ベースでTOP10を取得
$stmt = $pdo->prepare("
    SELECT score, play_time, played_at
    FROM score
    WHERE user_id = :user_id
    ORDER BY score DESC, play_time ASC, played_at ASC
    LIMIT 10
");
$stmt->execute([':user_id' => $userId]);
$userScores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>あなたのスコア</title>
    <style>
        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">📊 あなたのスコア TOP10</h2>
    <table>
        <thead>
            <tr>
                <th>順位</th>
                <th>スコア</th>
                <th>タイム（秒）</th>
                <th>日時</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($userScores)): ?>
                <tr><td colspan="4">記録がありません</td></tr>
            <?php else: ?>
                <?php foreach ($userScores as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($row['score']) ?></td>
                        <td><?= htmlspecialchars($row['play_time']) ?>秒</td>
                        <td><?= htmlspecialchars($row['played_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
