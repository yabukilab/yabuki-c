<?php
header('Content-Type: application/json');
require 'db.php';  // $db = new PDO(...)

session_start();

/**
 * 安全にPOSTを取り出して、数値にキャストする補助
 * （未指定なら null、数値でなければエラーにする）
 */
function get_int_post(string $key, &$raw)
{
    if (!isset($_POST[$key])) {
        return null;
    }
    $raw = $_POST[$key];
    // 数値文字列（"16" など）を許可
    if ($raw === '' || !is_numeric($raw)) {
        return null;
    }
    return (int)$raw;
}

$raw_user_id = $raw_score = $raw_play_time = null;
$user_id   = get_int_post('user_id',   $raw_user_id);
$score     = get_int_post('score',     $raw_score);
$play_time = get_int_post('play_time', $raw_play_time);

// ここで届いたかどうかを厳密にチェック（0 も有効値）
$errors = [];
if ($user_id === null)   { $errors[] = 'user_id'; }
if ($score === null)     { $errors[] = 'score'; }
if ($play_time === null) { $errors[] = 'play_time'; }

if ($errors) {
    echo json_encode([
        'status'  => 'error',
        'message' => '❌ データ不足（' . implode(', ', $errors) . '）',
        'received'=> [  // デバッグ用（開発中だけ使ってOK）
            'user_id'   => $raw_user_id ?? '(not set)',
            'score'     => $raw_score ?? '(not set)',
            'play_time' => $raw_play_time ?? '(not set)',
        ]
    ]);
    exit;
}

try {
    // 履歴ベースで毎回INSERT（played_atはDBのデフォルトでも良いが、明示でNOW()でもOK）
    $stmt = $db->prepare("
        INSERT INTO score (user_id, score, play_time, played_at)
        VALUES (:user_id, :score, :play_time, NOW())
    ");
    $stmt->execute([
        ':user_id'   => $user_id,
        ':score'     => $score,
        ':play_time' => $play_time,
    ]);

    echo json_encode([
        'status'  => 'success',
        'message' => '✅ スコアを保存しました',
        'debug'   => ['user_id'=>$user_id, 'score'=>$score, 'play_time'=>$play_time]
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => '❌ 保存失敗：DBエラー',
        'error'   => $e->getMessage()
    ]);
}
