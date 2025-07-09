<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php'; // $db を含む

try {
    $stmt = $db->query("
        SELECT username, best_score, best_score_time, best_score_playtime
        FROM users
        WHERE best_score IS NOT NULL
        ORDER BY best_score DESC
        LIMIT 10
    ");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
