<?php
session_start();

// Oracle DB connection
$conn = oci_connect("URBANFOODGROUP", "FOOD123", "localhost/FREEPDB1");

if (!$conn) {
    $e = oci_error();
    die("❌ Connection failed: " . $e['message']);
}

// Get form data
$email = $_POST['email'] ?? '';
$passwordInput = $_POST['password'] ?? '';

// Input validation
if (empty($email) || empty($passwordInput)) {
    header("Location: ../login.html?error=empty");
    exit;
}

// Query to find user by email
$sql = "SELECT CustomerID, Password, FirstName, LastName FROM Customer WHERE Email = :email";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ":email", $email);
oci_execute($stid);

$row = oci_fetch_assoc($stid);

if ($row) {
    $storedPassword = $row['PASSWORD'];

    // Password check (hashed or plain text)
    if (password_verify($passwordInput, $storedPassword) || $passwordInput === $storedPassword) {
        $_SESSION['CustomerID'] = $row['CUSTOMERID'];
        $_SESSION['email'] = $email;
        $_SESSION['username'] = trim($row['FIRSTNAME'] . ' ' . $row['LASTNAME']);

        // Redirect to dashboard/home
        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../login.html?error=invalid");
        exit;
    }
} else {
    header("Location: ../login.html?error=notfound");
    exit;
}

oci_free_statement($stid);
oci_close($conn);
?>
