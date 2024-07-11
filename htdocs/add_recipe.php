<!DOCTYPE html>
<html>
<head>
    <title>レシピ追加成功しました</title>
    <link rel="stylesheet" type="text/css" href="cookstyle.css">
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
    <h1>レシピの追加に成功しました</h1>
    <?php
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $ingredients = $_POST['ingredients'];
            $instructions = $_POST['instructions'];
            $image = NULL;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            }

            $stmt = $db->prepare("INSERT INTO recipes (name, ingredients, instructions, image) VALUES (:name, :ingredients, :instructions, :image)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':ingredients', $ingredients);
            $stmt->bindParam(':instructions', $instructions);
            $stmt->bindParam(':image', $image, PDO::PARAM_LOB);
            $stmt->execute();

            // 追加したレシピのIDを取得
            $last_id = $db->lastInsertId();

            // 追加したレシピの詳細を表示
            $sql = "SELECT name, ingredients, instructions, image FROM recipes WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $last_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                echo '<div class="recipe">';
                echo '<h3>' . htmlspecialchars($result['name']) . '</h3>';
                if ($result['image']) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($result['image']) . '" alt="Recipe Image">';
                }
                echo '<p><strong>食材:</strong><br>' . nl2br(htmlspecialchars($result['ingredients'])) . '</p>';
                echo '<p><strong>調理方法:</strong><br>' . nl2br(htmlspecialchars($result['instructions'])) . '</p>';
                echo '</div>';
            } else {
                echo '<p>レシピが見つかりませんでした。</p>';
            }
        } else {
            echo '<p>レシピの追加に失敗しました。</p>';
        }
    } catch (PDOException $e) {
        // 接続エラーの場合、エラーメッセージを表示
        echo "データベースに接続できません: " . htmlspecialchars($e->getMessage());
    }
    ?>
    <a href="index.php" class="btn btn-primary">戻る</a>
</div>
</body>
</html>
