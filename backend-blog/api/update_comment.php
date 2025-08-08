<?php
header("Content-Type: application/json");
require_once '../db_connection.php';

// Accept PUT data from body
$input = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($input['comment_id']) || !isset($input['content'])) {
    http_response_code(400);
    echo json_encode(['error' => 'comment_id and content are required']);
    exit;
}

$comment_id = intval($input['comment_id']);
$new_content = trim($input['content']);

try {
    $stmt = $pdo->prepare("UPDATE comments SET content = ? WHERE id = ?");
    $stmt->execute([$new_content, $comment_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Comment updated']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No comment updated. ID may not exist.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
?>
