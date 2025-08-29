<?php
# ランキング：全ユーザーから上位10件
# 失敗していた原因：$pdo が未定義。db.php の $db を $pdo に束縛して解決。

require __DIR__ . '/db.php';   # PDOは $db で提供される
$pdo = $db;                    # ← これがないと $pdo は null のまま

try {
    $sql = "
        SELECT u.username, s.score, s.play_time, s.played_at
        FROM score s
        JOIN users u ON s.user_id = u.id
        ORDER BY s.score DESC, s.play_time ASC, s.played_at ASC
        LIMIT 10
    ";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    http_response_code(500);
    echo "<p>ランキング取得中にエラーが発生しました。</p>";
    if (ini_get('display_errors')) {
        echo "<pre>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    }
    exit;
}

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>全体ランキング</title>
  <style>
    body { font-family: sans-serif; text-align:center; }
    table { margin:20px auto; border-collapse: collapse; min-width: 720px; }
    th, td { border:1px solid #999; padding:10px; }
    th { background:#f4f4f4; }
  </style>
</head>
<body>
  <h1>🏆 全体ランキング TOP10</h1>
  <table>
    <tr>
      <th>順位</th>
      <th>ユーザー名</th>
      <th>スコア</th>
      <th>タイム</th>
      <th>日時</th>
    </tr>
    <?php if (empty($rows)): ?>
      <tr><td colspan="5">記録がまだありません</td></tr>
    <?php else: ?>
      <?php foreach ($rows as $i => $r): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= h($r['username']) ?></td>
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
