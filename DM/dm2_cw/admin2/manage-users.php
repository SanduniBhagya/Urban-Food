<?php
session_start();
require_once '../config/database.php';
require_once 'includes/auth_check.php';

$error = '';
$success = '';

// Handle user management actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'delete' && isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ? AND role = 'customer'");
        if ($stmt->execute([$userId])) {
            $success = 'User deleted successfully!';
        } else {
            $error = 'Failed to delete user';
        }
    } elseif ($_POST['action'] === 'update' && isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';

        if (!empty($firstName) && !empty($lastName) && !empty($email)) {
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ? AND role = 'customer'");
            if ($stmt->execute([$firstName, $lastName, $email, $userId])) {
                $success = 'User updated successfully!';
            } else {
                $error = 'Failed to update user';
            }
        }
    }
}

// Fetch all customers
$stmt = $pdo->query("SELECT * FROM users WHERE role = 'customer' ORDER BY first_name, last_name");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - UrbanEats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">
    <?php include 'includes/sidebar.php'; ?>
    <div class="flex-1">
        <?php include 'includes/header.php'; ?>

        <main class="p-6">
            <h1 class="text-2xl font-semibold text-gray-900 mb-4">Manage Users</h1>

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

            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Customer Accounts</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr id="user-row-<?= $user['user_id'] ?>">
                                <form method="POST" action="manage-users.php">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <input type="hidden" name="action" value="update">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>"
                                               class="form-input w-full border border-gray-300 rounded px-2 py-1">
                                        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>"
                                               class="form-input w-full mt-1 border border-gray-300 rounded px-2 py-1">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                                               class="form-input w-full border border-gray-300 rounded px-2 py-1">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm flex space-x-3">
                                        <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 shadow">
                                            Save
                                        </button>
                                </form>
                                <form method="POST" action="manage-users.php"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 shadow">
                                        Delete
                                    </button>
                                </form>
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
