<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'db.php';

// Get the user's role
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

// Only allow Admin users to view the user list
if ($role !== 'Admin') {
    echo "You do not have permission to view this page.";
    exit();
}

// Fetch all users
$sql = "SELECT email, role, created_at FROM users";
$result = $conn->query($sql);

// Check for errors in the query
if (!$result) {
    echo "Error fetching users: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users - Dolphin CRM</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your existing CSS file -->
</head>
<body>
    <div class="header">
        <img src="https://e7.pngegg.com/pngimages/466/444/png-clipart-tattoo-flash-dolphin-cartoon-dolphin-marine-mammal-mammal.png" alt="Dolphin Logo" class="logo">
        <span class="header-text">Dolphin CRM</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../Home/dashboard.php" class="active"><img src="https://img.icons8.com/ios-filled/24/000000/home.png" alt="Home Icon"> Home</a>
        <a href="../New-Contact/new-contact.php"><img src="https://img.icons8.com/ios-filled/24/000000/add-contact-to-company.png" alt="New Contact Icon"> New Contact</a>
        <a href="../Users/view_users.php"><img src="https://img.icons8.com/ios-filled/24/000000/user-group-man-man.png" alt="Users Icon"> Users</a>
        <a href="../logout.php"><img src="https://img.icons8.com/ios-filled/24/000000/logout-rounded-left.png" alt="Logout Icon"> Logout</a>
    </div>

    <div class="main">
        <div class="card">
            <h2>Users</h2>
            <button class="add-user-btn" onclick="location.href='../Add-User/new_user.php'">+ Add User</button>

            <table>
                <tr>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date Created</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No users found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php

$conn->close();
?>