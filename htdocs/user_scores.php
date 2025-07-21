<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>成績表示</title>
    <style>
        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">あなたのスコア上位10件</h2>
    <table>
        <thead>
            <tr>
                <th>順位</th>
                <th>スコア</th>
                <th>タイム（秒）</th>
                <th>日時</th>
            </tr>
        </thead>
        <tbody id="scoreTable">
            <tr><td colspan="4">読み込み中...</td></tr>
        </tbody>
    </table>

    <script>
    fetch('get_user_scores.php')
        .then(res => res.json())
        .then(data => {
            const table = document.getElementById('scoreTable');
            table.innerHTML = '';
            if (data.error) {
                table.innerHTML = `<tr><td colspan="4">${data.error}</td></tr>`;
                return;
            }

            if (data.length === 0) {
                table.innerHTML = '<tr><td colspan="4">記録がありません</td></tr>';
                return;
            }

            data.forEach((row, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${row.best_score}</td>
                    <td>${row.best_time}</td>
                    <td>${row.best_datetime}</td>
                `;
                table.appendChild(tr);
            });
        })
        .catch(err => {
            document.getElementById('scoreTable').innerHTML =
                `<tr><td colspan="4">エラーが発生しました</td></tr>`;
            console.error(err);
        });
    </script>
</body>
</html>
