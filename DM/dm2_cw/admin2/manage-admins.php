<?php
session_start();
require_once '../config/database.php';
require_once 'includes/auth_check.php';

if ($_SESSION['admin_role'] !== 'head_admin') {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'create') {
        $first_name = $_POST['first_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';
        $db_username = $_POST['db_username'] ?? '';

        if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password) && !empty($role) && !empty($db_username)) {
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if (!$stmt->fetch()) {
                try {
                    // Create Oracle DB User
                    $pdo->exec("CREATE USER $db_username IDENTIFIED BY \"$password\"");

                    // Grant role-specific privileges
                    switch ($role) {
                        case 'admin':
                            $pdo->exec("GRANT CONNECT, RESOURCE, DBA TO $db_username");
                            break;
                        case 'moderator':
                            $pdo->exec("GRANT CONNECT, RESOURCE TO $db_username");
                            break;
                        case 'trainee':
                            $pdo->exec("GRANT CONNECT TO $db_username");
                            break;
                    }

                    // Insert into application-level users table
                    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
                    if ($stmt->execute([$first_name, $last_name, $email, $password, $role])) {
                        $success = 'Admin and DB user created successfully!';
                    } else {
                        $error = 'Failed to save admin in application database.';
                    }

                } catch (PDOException $e) {
                    $error = 'Database user creation failed: ' . $e->getMessage();
                }
            } else {
                $error = 'Email already exists.';
            }
        } else {
            $error = 'Please fill in all fields.';
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['admin_id'])) {
        $adminId = $_POST['admin_id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ? AND role != 'head_admin'");
        if ($stmt->execute([$adminId])) {
            $success = 'Admin deleted successfully!';
        } else {
            $error = 'Failed to delete admin';
        }
    } elseif ($_POST['action'] === 'update' && isset($_POST['admin_id'])) {
        $adminId = $_POST['admin_id'];
        $role = $_POST['role'] ?? '';
        if (!empty($role)) {
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE user_id = ? AND role != 'head_admin'");
            if ($stmt->execute([$role, $adminId])) {
                $success = 'Admin role updated successfully!';
            } else {
                $error = 'Failed to update admin role';
            }
        }
    }
}

$stmt = $pdo->query("SELECT * FROM users WHERE role != 'customer' ORDER BY first_name, last_name");
$admins = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins - UrbanEats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-1">
        <?php include 'includes/header.php'; ?>

        <main class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Manage Admins</h1>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- Create Admin Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Create New Admin</h2>
                <form method="POST" action="manage-admins.php">
                    <input type="hidden" name="action" value="create">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" name="first_name" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" name="last_name" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">DB Username</label>
                            <input type="text" name="db_username" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                                <option value="admin">Admin</option>
                                <option value="moderator">Moderator</option>
                                <option value="trainee">Trainee</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-green-500 text-white py-3 text-lg font-semibold rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 shadow-md">
                            Create Admin
                        </button>
                    </div>
                </form>
            </div>

            <!-- Admin Table -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Current Admins</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?= htmlspecialchars($admin['email']) ?>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if ($admin['role'] !== 'head_admin'): ?>
                                        <form method="POST" action="manage-admins.php" class="inline">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="admin_id" value="<?= $admin['user_id'] ?>">
                                            <select name="role" onchange="this.form.submit()" class="px-2 py-1 border rounded text-sm">
                                                <option value="admin" <?= $admin['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="moderator" <?= $admin['role'] === 'moderator' ? 'selected' : '' ?>>Moderator</option>
                                                <option value="trainee" <?= $admin['role'] === 'trainee' ? 'selected' : '' ?>>Trainee</option>
                                            </select>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-purple-800 text-sm font-semibold">Head Admin</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if ($admin['role'] !== 'head_admin'): ?>
                                        <form method="POST" action="manage-admins.php" class="inline" onsubmit="return confirm('Are you sure?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="admin_id" value="<?= $admin['user_id'] ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
