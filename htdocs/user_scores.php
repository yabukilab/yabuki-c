<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require 'db.php';
$pdo = $db;

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// このユーザーの全スコア履歴を取得
$sql = "
  SELECT score, play_time, played_at
  FROM score
  WHERE user_id = :user_id
  ORDER BY score DESC, play_time ASC, played_at ASC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($username) ?> さんの成績</title>
  <style>
    table { border-collapse: collapse; margin: 20px auto; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: center; }
  </style>
</head>
<body>
  <h2 style="text-align:center;">📊 <?= htmlspecialchars($username) ?> さんの成績</h2>
  <table>
    <tr>
      <th>順位</th><th>スコア</th><th>タイム</th><th>日時</th>
    </tr>
    <?php
    $rank = 1;
    foreach ($scores as $row):
    ?>
    <tr>
      <td><?= $rank++ ?>位</td>
      <td><?= htmlspecialchars($row['score']) ?></td>
      <td><?= htmlspecialchars($row['play_time']) ?> 秒</td>
      <td><?= htmlspecialchars($row['played_at']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <p style="text-align:center;"><a href="menu.php">🏠 メニューに戻る</a></p>
</body>
</html>
