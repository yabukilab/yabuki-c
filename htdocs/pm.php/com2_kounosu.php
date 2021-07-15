<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>口コミ一覧画面</title>
  <style>
    .title {
      text-align: center;
      padding-top: 20px;
      padding-bottom: 70px;
      font-size: 30px;
      text-decoration: underline #3b82c4;
    }

    .title p {
      margin-bottom: 0px;
    }

    .back {
      position: fixed;
      top: 0;
      right: 0;
      padding-top: 100px;
      padding-right: 70px;
    }

    .back input {
      font-size: 26px;
      text-align: center;
    }

    /* .heikin {
      text-align: center;
    }

    .heikin p {
      font-size: 20px;
    } */
  </style>
</head>

<body>


  <hr color="#3b82c4" size="40px">
  <div class="title">
    <p>ユーザビリティエンジニアリング</p>
  </div>

  <div class="back">
    <input type="button" onClick="location.href='http://localhost/sample/pm.php/1_kounosu.php'" value="戻る">
  </div>

  <!-- <div class="heikin">
    <p>評価の平均値:</p>
    
  </div> -->

  <div class=main>
    <table border=“1” align="center">
      <tr>
        <th>評価</th>
        <th>講義の感想</th>
        <th>日時</th>
      </tr>

      <?php
      require 'db.php';                                # 接続
      $sql = 'SELECT * FROM kutikomi WHERE class = 301';# SQL文
      $prepare = $db->prepare($sql);                   # 準備
      $prepare->execute();                             # 実行
      $result = $prepare->fetchAll(PDO::FETCH_ASSOC);  # 結果の取得
      $num = 0;                                        # DBに登録されているデータ数


      foreach ($result as $row) {
        $id = h($row['id']);
        $p = h($row['point']);
        $t = h($row['thoughts']);
        $d = h($row['day']);
        echo "<tr><td>　{$p}　</td><td>{$t}　　</td><td>　{$d}　</td</tr> ";
        $num++;
      }
      echo "<input type=\"hidden\" name=\"num\" value={$num}/>";
      ?>


    </table>
  </div>

</body>

</html>
