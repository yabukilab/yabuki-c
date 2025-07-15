<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <link rel='stylesheet' href='style.css' />
    <title>全データ表示（その1）</title>
  </head>
  <body>
<?php
require 'db.php';                               # 接続
$sql = 'SELECT * FROM users';                  # SQL文
$prepare = $db->prepare($sql);                  # 準備
$prepare->execute();                            # 実行
$result = $prepare->fetchAll(PDO::FETCH_ASSOC); # 結果の取得

foreach ($result as $row) {
  $id       = h($row['id']);
  $username = h($row['username']);
  $password     = h($row['password']);
  $is_admin     = h($row['is_admin']);
  $best_score     = h($row['best_score']);
  $best_time     = h($row['best_time']);
  echo "{$id}, {$username}, {$password}, {$is_admin}, {$best_score}. {$best_time}<br/>";
}
?>
  </body>
</html>