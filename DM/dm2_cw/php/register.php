<?php
// Connect using OCI8 instead of PDO
$conn = oci_connect("URBANFOODGROUP", "FOOD123", "//localhost:1521/FREEPDB1", "AL32UTF8");

if (!$conn) {
    $e = oci_error();
    die("❌ Connection failed: " . htmlentities($e['message'], ENT_QUOTES));
}

// Get POST data
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone_number'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Validate passwords
if ($password !== $confirmPassword) {
    header("Location: ../register.html?error=pass_mismatch");
    exit;
}

// Encrypt password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL
$sql = "INSERT INTO CUSTOMER (FirstName, LastName, Email, PhoneNumber, Password)
        VALUES (:fname, :lname, :email, :phone, :pass)";

// Prepare statement
$stmt = oci_parse($conn, $sql);

// Bind parameters
oci_bind_by_name($stmt, ":fname", $firstName);
oci_bind_by_name($stmt, ":lname", $lastName);
oci_bind_by_name($stmt, ":email", $email);
oci_bind_by_name($stmt, ":phone", $phone);
oci_bind_by_name($stmt, ":pass", $hashedPassword);

// Execute
if (oci_execute($stmt)) {
    header("Location: ../login.html?register=success");
    exit;
} else {
    $e = oci_error($stmt);
    echo "❌ Query Error: " . htmlentities($e['message'], ENT_QUOTES);
}

oci_free_statement($stmt);
oci_close($conn);
?>
