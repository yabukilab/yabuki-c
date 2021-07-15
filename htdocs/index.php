<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset='utf-8' />
  <link rel='stylesheet' href='style.css' />
  <title>教員一覧</title>

  <style>
    h1 {
      color: #000;
      font-size: 30px;
      font-weight: 600;
      text-align: center;
      display: block;
      margin-left: 0px;
      margin-right: 0px;
    }

    .title {
      text-align: center;
      padding: 40px;
      font-size: 26px;
      font-weight: 0;
      padding-bottom: 0;
      text-decoration: underline #3b82c4;
    }

    .title p {
      margin: 0px;
    }

    .kyouin {
      text-align: center;
      display: block;
      font-size: 20px;
    }



    .kyouin1 {
      display: inline-block;
      vertical-align: middle;
      padding-right: 30px;
    }

    .kyouin2 {
      display: inline-block;
      vertical-align: middle;
      padding-right: 30px;
    }

    .kyouin3 {
      display: inline-block;
      vertical-align: middle;
    }

    .logbt {
      width: 60px;
      background-color: #aaaaaa;
      border-radius: 3px;
      box-shadow: 0 3px 0 rgba(136, 136, 136, 1);
      color: #ffffff;
      display: block;
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      margin: 10px auto;
    }

    .logbt:hover {
      box-shadow: 0 1px 0 rgba(136, 136, 136, 1);
      margin: 12px auto 8px;
    }

    .login p {
      font-size: 16px;
    }

    .logbt input {
      font-size: 20px;
    }
  </style>
</head>

<script language="JavaScript">
  function jump() {
    var flag = 0;
    for (i = 0; i < document.forms[0].url.length; i++) {
      if (document.forms[0].url[i].checked) {
        flag = 1;
        window.location.href = document.forms[0].url[i].value;
      }
    }
    if (flag == 0) {
      alert('ラジオボタンが選択されていません。');
    }
  }
</script>

<body>
  <hr color="#3b82c4" size="40px">
  <h1>千葉工業大学講義口コミ掲示板</h1>

  <div class="title">
    <p>PM学科教員一覧</p><br>
  </div>

  <form>
    <div class="kyouin">
      <div class="kyouin1">
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_ogasawara.php" class="sensei">小笠原秀人<br>
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_katou.php" class="sensei">加藤和彦　<br>
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_kounosu.php" class="sensei">鴻巣努　　<br>
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_shimoda.php" class="sensei">下田篤　　<br>
      </div>

      <div class="kyouin2">
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_shimomura.php" class="sensei">下村道夫　<br>
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_seki.php" class="sensei">関研一　　<br>
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_takuma.php" class="sensei">田隈広紀　<br>
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_takeda.php" class="sensei">武田善行　<br>
      </div>

      <div class="kyouin3">
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_tanimoto.php" class="sensei">谷本茂明　<br>
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_tooyama.php" class="sensei">遠山正朗　<br>
        <input TYPE="radio" name="url" value="http://localhost/sample/pm.php/1_yabuki.php" class="sensei">矢吹太朗　<br>
        　　　　　

      </div>
    </div>
    <br>

    <div class="logbt">
      <input TYPE="button" onClick="jump();" value="検索">
    </div>
  </form>

  </form>
</body>

</html>
