<?php
require 'db.php';
$pdo = $db;

// 最新のランキングTOP10を取得（スコア降順 → タイム昇順 → 日付昇順）
$sql = "
  SELECT u.username, s.score, s.play_time, s.played_at
  FROM score s
  JOIN users u ON s.user_id = u.id
  ORDER BY s.score DESC, s.play_time ASC, s.played_at ASC
  LIMIT 10
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ランキング</title>
  <style>
    table { border-collapse: collapse; margin: 20px auto; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: center; }
  </style>
</head>
<body>
  <h2 style="text-align:center;">🏆 ランキング TOP10</h2>
  <table>
    <tr>
      <th>順位</th><th>ユーザー名</th><th>スコア</th><th>タイム</th><th>日時</th>
    </tr>
    <?php
    $rank = 1;
    foreach ($ranking as $row):
    ?>
    <tr>
      <td><?= $rank++ ?>位</td>
      <td><?= htmlspecialchars($row['username']) ?></td>
      <td><?= htmlspecialchars($row['score']) ?></td>
      <td><?= htmlspecialchars($row['play_time']) ?> 秒</td>
      <td><?= htmlspecialchars($row['played_at']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <p style="text-align:center;"><a href="menu.php">🏠 メニューに戻る</a></p>
</body>
</html>
