<?php
require 'dbM.php';
header('Content-Type: application/json');

$query = new MongoDB\Driver\Query([], [
    'sort' => ['created_at' => -1],
    'limit' => 50
]);

try {
    $cursor = $mongoManager->executeQuery("$databaseName.$collectionName", $query);
    $reviews = [];

    foreach ($cursor as $doc) {
        $createdAt = '';
        if (isset($doc->created_at) && $doc->created_at instanceof MongoDB\BSON\UTCDateTime) {
            $createdAt = $doc->created_at->toDateTime()->format('Y-m-d H:i');
        } else if (is_string($doc->created_at)) {
            $createdAt = $doc->created_at;
        }

        $reviews[] = [
            'user_id' => $doc->user_id ?? '',
            'username' => $doc->username ?? 'Anonymous',
            'rating' => $doc->rating ?? 0,
            'review' => $doc->review ?? '',
            'created_at' => $createdAt
        ];
    }

    echo json_encode($reviews);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load reviews: ' . $e->getMessage()]);
}
?>
