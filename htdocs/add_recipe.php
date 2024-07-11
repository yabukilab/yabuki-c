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
                <li><a href="#">ホーム</a></li>
                <li><a href="#">レシピ一覧</a></li>
                <li><a href="#">お問い合わせ</a></li>
            </ul>
        </nav>
    </header>
<div class="container">
    <h1>レシピの追加に成功しました</h1>
    <?php
    $conn = new mysqli('127.0.0.1', 'testuser', 'pass', 'yabukic');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];
        $image = NULL;

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
        }

        $stmt = $conn->prepare("INSERT INTO recipes (name, ingredients, instructions, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $ingredients, $instructions, $image);
        $stmt->send_long_data(3, $image);
        $stmt->execute();

        // 追加したレシピのIDを取得
        $last_id = $stmt->insert_id;

        $stmt->close();

        // 追加したレシピの詳細を表示
        $sql = "SELECT name, ingredients, instructions, image FROM recipes WHERE id = $last_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<div class="recipe">';
            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
            if ($row['image']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Recipe Image">';
            }
            echo '<p><strong>食材:</strong><br>' . nl2br(htmlspecialchars($row['ingredients'])) . '</p>';
            echo '<p><strong>調理方法:</strong><br>' . nl2br(htmlspecialchars($row['instructions'])) . '</p>';
            echo '</div>';
        } else {
            echo '<p>レシピが見つかりませんでした。</p>';
        }
    } else {
        echo '<p>レシピの追加に失敗しました。</p>';
    }

    $conn->close();
    ?>
    <a href="index.php" class="btn btn-primary">戻る</a>
</div>
</body>
</html>
