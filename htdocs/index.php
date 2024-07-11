<!DOCTYPE html>
<html>
<head>
    <title>レシピ追加</title>
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
    <h2>レシピ追加</h2>
    <form action="add_recipe.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">料理名:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="ingredients">食材:段落に分けて可能な限り詳細に書き加えてください</label>
            <textarea id="ingredients" name="ingredients" required></textarea>
        </div>
        <div class="form-group">
            <label for="instructions">調理方法:段落に分けて可能な限り詳細に書き加えてください</label>
            <textarea id="instructions" name="instructions" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">料理の写真:</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        <button type="submit">追加</button>
    </form>
    <br>
    <a href="webpage.html" class="btn btn-primary">戻る</a>
</div>
</body>
</html>
