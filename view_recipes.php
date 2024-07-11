<!DOCTYPE html>
<html>
<head>
    <title>レシピ一覧</title>
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
    <h2>レシピ一覧</h2>
    <?php
    $conn = new mysqli('localhost', 'root', '', 'recipe_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT name, ingredients, instructions, image FROM recipes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
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
        echo 'レシピが見つかりませんでした。';
    }
    $conn->close();
    ?>
</div>
</body>
</html>
