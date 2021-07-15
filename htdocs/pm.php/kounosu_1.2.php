<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザビリティエンジニアリング</title>
  <style>
    h1 {
      text-align: center;
      padding-top: 20px;
      text-decoration: underline #3b82c4;
    }

    .kutikomi {
      text-align: center;
      padding: 0px;
      font-size: 18px;
      margin-bottom: 30px;
      margin-top: 40px;
    }

    .day {
      text-align: center;
    }

    .hyouka {
      display: block;
      text-align: center;
      padding-top: 30px;
    }

    .kijyutu {
      text-align: center;
      padding-top: 20px;

    }

    .kijyutu textarea {
      font-size: 15px;
    }

    .btn {
      text-align: center;
      padding-top: 20px;
    }

    .btn button {
      font-size: 20px;
    }

    .back {
      position: fixed;
      top: 0;
      right: 0;
      padding-top: 90px;
      padding-right: 70px;
    }

    .back input {
      font-size: 26px;
      text-align: center;
    }

    .button {
      display: inline-block;
      border-radius: 5%;
      /* 角丸       */
      font-size: 12pt;
      /* 文字サイズ */
      text-align: center;
      /* 文字位置   */
      cursor: pointer;
      /* カーソル   */
      padding: 8px 12px;
      /* 余白       */
      background: #dddddd;
      /* 背景色     */
      color: #000000;
      /* 文字色     */
      line-height: 1em;
      /* 1行の高さ  */
      transition: 0.3s;
      /* なめらか変化 */
      border: 2px solid #3b82c4;
      /* 枠の指定 */
    }

    .button:hover {
      box-shadow: none;
      /* カーソル時の影消去 */
      color: #000066;
      /* 背景色     */
      background: #ffffff;
      /* 文字色     */
    }
  </style>
</head>

<body>
  <hr color="#3b82c4" size="40px">
  <h1>ユーザビリティエンジニアリング</h1>

  <div class="back">
    <input type="button" onClick="location.href='http://localhost/sample/pm.php/1_kounosu.php'" value="戻る">
  </div>

  <div class="kutikomi">
    <p>口コミをお書きください</p>
  </div>

  <form action="post_kounosu2.php" method="post">

    <div class="day">
      <input type="date" id="today" name="day">
    </div>
    <script type="text/javascript">
      //今日の日時を表示
      window.onload = function() {
        //今日の日時を表示
        var date = new Date()
        var year = date.getFullYear()
        var month = date.getMonth() + 1
        var day = date.getDate()

        var toTwoDigits = function(num, digit) {
          num += ''
          if (num.length < digit) {
            num = '0' + num
          }
          return num
        }

        var yyyy = toTwoDigits(year, 4)
        var mm = toTwoDigits(month, 2)
        var dd = toTwoDigits(day, 2)
        var ymd = yyyy + "-" + mm + "-" + dd;

        document.getElementById("today").value = ymd;
      }
    </script>

    <div class="hyouka">
      評価：<input TYPE="radio" name="point" value="1">1
      <input TYPE="radio" name="point" value="2">2
      <input TYPE="radio" name="point" value="3">3
      <input TYPE="radio" name="point" value="4">4
      <input TYPE="radio" name="point" value="5">5
      <br>
    </div>

    <?php
    if (isset($p)) {
      switch ($p) {
        case "1":
          echo '1';
          break;
        case "2":
          echo '3';
          break;
        case "3";
          echo '3';
          break;
        case "4":
          echo '4';
          break;
        case "5":
          echo '5';
          break;
      }
    }
    ?>

    <div class="kijyutu">
      <textarea name="thoughts" cols="50" rows="5" placeholder="授業の感想をお書きください"></textarea>
      <br>
    </div>

    <input type="hidden" name="class" value="301">
    <input type="hidden" name="name" value="kounosu">


    <div class="btn">
      <input type="submit" value="送信" class="button" />
      <input type="reset" value="リセット" class="button"/>
    </div>
  </form>
</body>

</html>
