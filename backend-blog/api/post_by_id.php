<?php
header("Content-Type: application/json");
require_once '../db_connection.php';

// Read raw input JSON from body
$input = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($input['post_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'post_id is required']);
    exit;
}

$post_id = intval($input['post_id']);

try {
    // Fetch post info + author
    $stmt = $pdo->prepare("
        SELECT posts.id, posts.title, posts.content, users.name AS author
        FROM posts
        JOIN users ON posts.user_id = users.id
        WHERE posts.id = ?
    ");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();

    if (!$post) {
        http_response_code(404);
        echo json_encode(['error' => 'Post not found']);
        exit;
    }

    // Fetch last 15 comments for that post
    $stmt = $pdo->prepare("
        SELECT comments.content, users.name AS author
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE comments.post_id = ?
        ORDER BY comments.id DESC
        LIMIT 15
    ");
    $stmt->execute([$post_id]);
    $comments = $stmt->fetchAll();

    $post['comments'] = $comments;

    echo json_encode($post);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
?>
