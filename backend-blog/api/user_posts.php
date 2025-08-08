<?php
header("Content-Type: application/json");
require_once '../db_connection.php';

// Read input
$input = json_decode(file_get_contents("php://input"), true);

// Validate
if (!isset($input['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'user_id is required']);
    exit;
}

$user_id = intval($input['user_id']);

try {
    $stmt = $pdo->prepare("
        SELECT posts.id, posts.title, posts.content, users.name AS author
        FROM posts
        JOIN users ON posts.user_id = users.id
        WHERE users.id = ?
        ORDER BY posts.id DESC
        LIMIT 10
    ");
    $stmt->execute([$user_id]);
    $posts = $stmt->fetchAll();

    echo json_encode($posts);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
?>
