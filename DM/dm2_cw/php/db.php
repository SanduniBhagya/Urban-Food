<?php
// Native MongoDB connection (no Composer required)

// Create a reusable MongoDB connection (Manager object)
$mongoManager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

// For future use, define your database and collection names
$databaseName = "URBANFOODGROOP";
$collectionName = "reviews";
