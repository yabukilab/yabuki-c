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
        $conn = new mysqli('localhost', 'root', '', 'recipe_db');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // 検索クエリを取得
        $query = $_GET['query'];

        // カタカナをひらがなに変換する関数
        function katakanaToHiragana($string) {
            return mb_convert_kana($string, 'c', 'UTF-8');
        }

        // ひらがなをカタカナに変換する関数
        function hiraganaToKatakana($string) {
            return mb_convert_kana($string, 'C', 'UTF-8');
        }

        // カタカナとひらがなを両方含めたクエリを構築
        $hiraganaQuery = katakanaToHiragana($query);
        $katakanaQuery = hiraganaToKatakana($query);
        $sql = "SELECT id, name, ingredients, instructions, image FROM recipes WHERE name LIKE '%$query%' OR name LIKE '%$hiraganaQuery%' OR name LIKE '%$katakanaQuery%'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<h2>検索結果</h2>';
            while ($row = $result->fetch_assoc()) {
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

        $conn->close();
    }
    ?>
    <br>
    <a href="webpage.html" class="btn btn-primary">戻る</a>
</div>
</body>
</html>
