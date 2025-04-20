<?php
if (!isset($_SESSION['admin_id']) || !in_array($_SESSION['admin_role'], ['head_admin', 'admin', 'moderator', 'trainee'])) {
    header('Location: login.php');
    exit();
}
?>