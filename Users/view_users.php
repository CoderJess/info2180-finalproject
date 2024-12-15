<?php
session_start();
//$_SESSION['user_id'] = 1; // Simulate logged-in user
//$_SESSION['user_role'] = 'admin';
// Check if the user is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo "Access denied. Admins only.";
    exit;
}

// Database connection details
$servername = "localhost";
$username = "crm_user";
$password = "password123";
$dbname = "dolphin_crm";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all users with concatenated title and name
    $sql = "SELECT CONCAT(title, ' ', firstname, ' ', lastname) AS full_name, 
                   email, 
                   role, 
                   DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS created_at 
            FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        /* Page styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .container {
            margin: 20px auto;
            max-width: 1000px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #e1e1e1;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="container">
        <h1>Users</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($user['full_name']); ?></strong></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars(ucfirst($user['role'])); ?></td>
                            <td><?= htmlspecialchars($user['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
