<?php
$databaseName = "URBANFOODGROUP";
$collectionName = "reviews";

try {
    $mongoManager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
} catch (MongoDB\Driver\Exception\Exception $e) {
    die("MongoDB connection failed: " . $e->getMessage());
}
?>
