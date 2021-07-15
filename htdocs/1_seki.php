<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>関研一先生授業一覧</title>
  <style>
    .title {
      text-align: center;
      padding-top: 20px;
      padding-bottom: 30px;
      font-size: 30px;
      text-decoration: underline #3b82c4;
    }

    .title p {
      margin-bottom: 0px;
    }

    .jyugyou {
      display: block;
      text-align: center;
      padding-top: 40px;
    }

    .jyugyou2 {
      padding-bottom: 40px;
    }

    a {
      text-decoration: none;
      color: #000;
      transition: 0.4s;
      font-size: 18px;
    }

    a:hover {
      color: #3b82c4;
    }

    .comment {
      padding-top: 10px;
    }

    .btn {
      display: inline-block;
      width: 240px;
      max-width: 100%;
      padding: 15px 10px;
      background-color: #dddddd;
      border: 2px solid transparent;
      border-bottom-color: #3b82c4;
      border-radius: 10px;
      color: #000;
      font-size: 1.125rem;
      text-align: center;
      text-decoration: none;
      transition: 0.8s;
    }

    .btn:focus,
    .btn:hover {
      background-color: #fff;
      border-color: currentColor;
      color: #3b82c4;
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
  </style>
</head>

<body>
  <hr color="#3b82c4" size="40px">

  <div class="title">
    <p>関研一先生授業一覧</p>
  </div>

  <div class="back">
    <input type="button"  onClick="location.href='http://localhost/sample/pm.php/member.php'" value="戻る">
  </div>

  <div class="jyugyou">
    <div class="jyugyou2">
      <button type="button" onclick="location.href='com1_seki.php'" class="btn" style="width:300px">プロジェクトマネジメント概論</button><br>
      <div class="comment">
        <a href="http://localhost/sample/pm.php/seki_1.1.php">コメントを書く</a>
      </div>
    </div>

    <div>
      <button type="button" onclick="location.href='com2_seki.php'" class="btn" style="width:300px">プロジェクト運営と意思決定</button><br>
      <div class="comment">
        <a href="http://localhost/sample/pm.php/seki_1.2.php">コメントを書く</a>
      </div>
    </div>
  </div>

</body>

</html>
