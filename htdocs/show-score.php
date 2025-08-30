<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>スコア全件表示</title>
</head>
<body>
<?php
require 'db.php';

$sql = 'SELECT * FROM score ORDER BY played_at DESC';
$prepare = $db->prepare($sql);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
    foreach ($result as $row) {
        $id        = h($row['id']);
        $user_id   = h($row['user_id']);
        $score     = h($row['score']);
        $play_time = h($row['play_time']);
        $played_at = h($row['played_at']);
        echo "ID: {$id}, ユーザーID: {$user_id}, スコア: {$score}, タイム: {$play_time}, 日時: {$played_at}<br>";
    }
} else {
    echo "スコアの記録はまだありません。";
}
?>
</body>
</html>
