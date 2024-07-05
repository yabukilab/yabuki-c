<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="cookstyle.css">
    <meta charset="UTF-8">
    <title>レシピ追加</title>
    <style>
        .recipe {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
        }
        .recipe img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_db";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続チェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームデータの取得
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $image = $_FILES['image']['tmp_name'];

    // 画像ファイルをBLOBとして読み込み
    $imageData = file_get_contents($image);

    // プリペアドステートメントの準備
    $stmt = $conn->prepare("INSERT INTO recipes (name, ingredients, instructions, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $ingredients, $instructions, $imageData);

    // データベースへの挿入
    if ($stmt->execute()) {
        $last_id = $stmt->insert_id; // 最後に挿入されたレコードのIDを取得
        header("Location: add_recipe.php?id=$last_id"); // 新しいレシピの詳細を表示するためにリダイレクト
        exit();
    } else {
        echo "エラー: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // レシピデータの取得
    $stmt = $conn->prepare("SELECT name, ingredients, instructions, image FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<div class='recipe'>";
        echo "<h2>" . htmlspecialchars($row["name"]) . "</h2>";
        if (!empty($row["image"])) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row["image"]) . '" alt="料理の写真">';
        }
        echo "<p><strong>食材:</strong><br>" . nl2br(htmlspecialchars($row["ingredients"])) . "</p>";
        echo "<p><strong>調理方法:</strong><br>" . nl2br(htmlspecialchars($row["instructions"])) . "</p>";
        echo "</div>";
    } else {
        echo "レシピが見つかりません。";
    }

    $stmt->close();
}

$conn->close();
?>
<a href="index.php" class="btn btn-primary">戻る</a>
</body>
</html>
