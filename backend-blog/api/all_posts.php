<?php
// all_posts.php
header("Content-Type: application/json");
require_once '../db_connection.php';

try {
    $stmt = $pdo->query("
        SELECT 
            posts.id, 
            posts.title, 
            posts.content, 
            users.name AS author,
            (
                SELECT COUNT(*) 
                FROM comments 
                WHERE comments.post_id = posts.id
            ) AS comment_count
        FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.id DESC
    ");

    $posts = $stmt->fetchAll();
    echo json_encode($posts);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch posts']);
}
?>
