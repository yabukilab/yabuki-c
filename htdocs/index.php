<?php
session_start(); // セッションを開始する．
$message = 'ユーザIDとパスワードを入力してください'; // デフォルトメッセージ

if (isset($_POST['username'], $_POST['password'])) {
  $username = $_POST['username']; // フォームから送信されたユーザ名
  $password = $_POST['password']; // フォームから送信されたパスワード

  //データベースに問い合わせる
  //データベース接続設定
  $dbServer = '127.0.0.1';
  $dbName = 'mydb2';
  $dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
  $dbUser = 'test';
  $dbPass = 'pass';

  //データベースへの接続
  $db = new PDO($dsn, $dbUser, $dbPass);

  //検索実行
  $sql = 'select * from userinfo where username = "' . $username . '" and passwd = "' . $password . '"';

  $prepare = $db->prepare($sql);
  $prepare->execute();
  $result = $prepare->fetchAll(PDO::FETCH_ASSOC);

  if ($result != null) {

    session_regenerate_id(); //セッションを作り直す．
    $_SESSION['username'] = $username; // ユーザ名を記憶する．

    session_start(); //メンバーならログイン可
    if (!isset($_SESSION["member"])) {
      $username = "member.php";
      header("Location: {$username}");
      exit;
    }
  }

  $message = 'ユーザ名またはパスワードが違います．';
} // ユーザ名とパスワードが送信されていないなら以下のフォームを表示する．
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset='utf-8' />
  <title>ログイン</title>

<style>
body {
  background-color: #fff;
}

.title p {
  color: #000;
  font-size: 30px;
  font-weight: 600;
  text-align: center;
  display: block;
  margin-left: 0px;
  margin-right: 0px;
}

.mess {
  text-align: center;
  padding: 40px;
  font-size: 18px;
  font-weight: 600;
}

.login {
  margin-left: auto;
  margin-right: auto;
  width: 8em;
  padding-right: 80px;
}

.login p {
  font-size: 16px;
}

.logbt {
  margin-top: 20px;
}

.logbt input {
  font-size: 18px;
}
</style>
</head>


<body>
<hr color="#3b82c4" size="40px">

  <div class="title">
    <p>千葉工業大学講義口コミ掲示板</p>
  </div>

  <div class="mess">
  <?php echo $message;?>
  </div>
 
  <div class="login2">
  <form action="index.php" method="post">
    <ul style="list-style-type: none;" class="login">
      <li>ユーザＩＤ<input type="text" name="username" placeholder="ユーザID" /></li>
      <li>パスワード<input type="password" name="password" placeholder="パスワード" /></li>
      <li class="logbt"><input type="submit" value="ログイン" /></li>
    </ul>
  </form>
  </div>
</body>

</html>
