<?php
try {
    $conn = new PDO("oci:dbname=localhost:1521/FREEPDB1;charset=AL32UTF8", "URBANFOODGROUP", "FOOD123");
    echo "✅ Oracle DB Connected!";
} catch (PDOException $e) {
    echo "❌ " . $e->getMessage();
}
?>
