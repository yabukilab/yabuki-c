<?php
# user_scores.php — ログインユーザーの上位10件
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/db.php';
$pdo = $db;

$userId = (int)$_SESSION['user_id'];

try {
    $sql = "
        SELECT score, play_time, played_at
        FROM score
        WHERE user_id = :uid
        ORDER BY score DESC, play_time ASC, played_at ASC
        LIMIT 10
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':uid' => $userId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    http_response_code(500);
    echo "<p>スコア取得中にエラーが発生しました。</p>";
    if (ini_get('display_errors')) {
        echo "<pre>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    }
    exit;
}

// db.php 側の h() を使う（db.php に h が定義されている前提）
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>あなたの成績</title>
  <style>
    body { font-family: sans-serif; text-align:center; }
    table { margin:20px auto; border-collapse: collapse; min-width: 720px; }
    th, td { border:1px solid #999; padding:10px; }
    th { background:#f4f4f4; }
  </style>
</head>
<body>
  <h2>あなたのスコア上位10件</h2>
  <table>
    <tr>
      <th>順位</th>
      <th>スコア</th>
      <th>タイム</th>
      <th>日時</th>
    </tr>
    <?php if (empty($rows)): ?>
      <tr><td colspan="4">記録がまだありません</td></tr>
    <?php else: ?>
      <?php foreach ($rows as $i => $r): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= (int)$r['score'] ?></td>
          <td><?= (int)$r['play_time'] ?>秒</td>
          <td><?= h($r['played_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </table>

  <p><a href="menu.php">メニューに戻る</a></p>
</body>
</html>
