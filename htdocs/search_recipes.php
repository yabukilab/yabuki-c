<!DOCTYPE html>
<html>
<head>
    <title>レシピ検索</title>
    <link rel="stylesheet" type="text/css" href="cookstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <h1>クッキングパパパット</h1>
        <nav>
            <ul>
                <li><a href="webpage.html">ホーム</a></li>
                <li><a href="view_recipes.php">レシピ一覧</a></li>
            </ul>
        </nav>
    </header>
<div class="container">
    <h2>レシピ検索</h2>
    <form action="search_recipes.php" method="get">
        <div class="form-group">
            <label for="query">料理名を入力</label>
            <input type="text" id="query" name="query" required>
        </div>
        <button type="submit">検索</button>
    </form>

    <?php
    if (isset($_GET['query'])) {
        // データベース接続情報の設定
        $dbServer = isset($_ENV['MYSQL_SERVER'])    ? $_ENV['MYSQL_SERVER']      : '127.0.0.1';
        $dbUser = isset($_SERVER['MYSQL_USER'])     ? $_SERVER['MYSQL_USER']     : 'testuser';
        $dbPass = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : 'pass';
        $dbName = isset($_SERVER['MYSQL_DB'])       ? $_SERVER['MYSQL_DB']       : 'yabukic';

        // データベース接続のためのDSN設定
        $dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";

        try {
            // データベースに接続
            $db = new PDO($dsn, $dbUser, $dbPass);
            // プリペアドステートメントのエミュレーションを無効にする
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            // エラーモードを例外に設定
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 検索クエリを取得
            $query = $_GET['query'];

            // カタカナをひらがなに変換
            $hiraganaQuery = mb_convert_kana($query, 'c');

            // SQLクエリを準備
            $sql = "SELECT id, name, ingredients, instructions, image FROM recipes WHERE name LIKE :query OR name LIKE :hiraganaQuery";
            $stmt = $db->prepare($sql);
            $likeQuery = "%$query%";
            $likeHiraganaQuery = "%$hiraganaQuery%";
            $stmt->bindParam(':query', $likeQuery);
            $stmt->bindParam(':hiraganaQuery', $likeHiraganaQuery);
            $stmt->execute();

            // 結果を取得
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                echo '<h2>検索結果</h2>';
                foreach ($result as $row) {
                    echo '<div class="recipe">';
                    echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
                    if ($row['image']) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Recipe Image">';
                    }
                    echo '<p><strong>食材:</strong><br>' . nl2br(htmlspecialchars($row['ingredients'])) . '</p>';
                    echo '<p><strong>調理方法:</strong><br>' . nl2br(htmlspecialchars($row['instructions'])) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>レシピが見つかりませんでした。</p>';
            }
        } catch (PDOException $e) {
            // 接続エラーの場合、エラーメッセージを表示
            echo "データベースに接続できません: " . htmlspecialchars($e->getMessage());
        }
    }
    ?>
    <br>
    <a href="webpage.html" class="btn btn-primary">戻る</a>
</div>
</body>
</html>
