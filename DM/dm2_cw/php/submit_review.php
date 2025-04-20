<?php
require 'db.php';
session_start();
header('Content-Type: application/json');

$rating = $_POST['rating'] ?? null;
$review = $_POST['review'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? 'Anonymous';

if (!$rating || !$review || !$user_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing fields']);
    exit;
}

$doc = [
    'user_id' => $user_id,
    'username' => $username,
    'rating' => (int)$rating,
    'review' => $review,
    'created_at' => new MongoDB\BSON\UTCDateTime()
];

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->insert($doc);

try {
    $mongoManager->executeBulkWrite("$databaseName.$collectionName", $bulk);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Insert failed: ' . $e->getMessage()]);
}
?>
