<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <link rel='stylesheet' href='style.css' />
  <title>データの追加完了</title>
  <style>
    h1 {
      text-align: center;
      padding-top: 30px;
    }

    h2 {
      text-align: center;
      padding-top: 20px;
    }

    p {
      text-align: center;
      font-size: 20px;
      padding-top: 30px;
    }

    .btn {
      text-align: center;
      margin-top: 20px;
    }

    .btn input {
      font-size: 18px;
      margin-top: 20px;
    }
  </style>
</head>

<body>

  <?php
  # 送信されたデータの取得
  $p = $_POST['point'];  
  $t = $_POST['thoughts']; 
  $d = $_POST['day'];  
  $c = $_POST['class'];
  $n = $_POST['name'];

  require 'db.php'; # 接続
  $sql = 'SELECT * FROM kutikomi' ;
  $sql =  'insert into  kutikomi (point, thoughts, day, class, name) values (:p, :t, :d, :c, :n)';

  $prepare = $db->prepare($sql); # 準備
  $prepare->bindValue(':p', $p, PDO::PARAM_STR);  
  $prepare->bindValue(':t', $t, PDO::PARAM_STR);      
  $prepare->bindValue(':d', $d, PDO::PARAM_STR);      
  $prepare->bindValue(':c', $c, PDO::PARAM_STR);      
  $prepare->bindValue(':n', $n, PDO::PARAM_STR);      

  $prepare->execute(); # 実行
  ?>


  <hr color="#3b82c4" size="40px">
  <h1>千葉工業大学講義口コミ掲示板</h1>
  <h2>口コミを確定しました</h2>
  <p>書き込んでくださりありがとうございます!</p>

  <div class="btn">
    <input type="button" onClick="location.href='http://localhost/sample/pm.php/com1_shimomura.php'" value="口コミ一覧画面へ">
  </div>
</body>

</html>
