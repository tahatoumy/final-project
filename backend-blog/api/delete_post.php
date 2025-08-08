<?php
header("Content-Type: application/json");
require_once '../db_connection.php';

// Get DELETE data from body
$input = json_decode(file_get_contents("php://input"), true);

// Validate
if (!isset($input['post_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'post_id is required']);
    exit;
}

$post_id = intval($input['post_id']);

try {
    // Delete post
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Post deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No post deleted. ID may not exist.']);
    }
}catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error', 'details' => $e->getMessage()]);
}
?>