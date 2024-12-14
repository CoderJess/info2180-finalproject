<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: Login/login.php');
    exit();
}

include 'db.php'; // Include database connection

// Fetch contacts from the database
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$sql = "SELECT title, first_name, last_name, email, company, type FROM contacts";

if ($filter === 'sales') {
    $sql .= " WHERE type = 'Sales Lead'";
} elseif ($filter === 'support') {
    $sql .= " WHERE type = 'Support'";
} elseif ($filter === 'assigned') {
    $user_id = $_SESSION['user_id'];
    $sql .= " WHERE assigned_to = ?";
}

$stmt = $conn->prepare($sql);
if (isset($user_id)) {
    $stmt->bind_param('i', $user_id);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="https://e7.pngegg.com/pngimages/466/444/png-clipart-tattoo-flash-dolphin-cartoon-dolphin-marine-mammal-mammal.png" alt="Dolphin Logo" class="logo">
        <span class="header-text">Dolphin CRM</span>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="dashboard.php" class="active"><img src="https://img.icons8.com/ios-filled/24/000000/home.png" alt="Home Icon"> Home</a>
        <a href="add_contact.php"><img src="https://img.icons8.com/ios-filled/24/000000/add-contact-to-company.png" alt="New Contact Icon"> New Contact</a>
        <a href="view_users.php"><img src="https://img.icons8.com/ios-filled/24/000000/user-group-man-man.png" alt="Users Icon"> Users</a>
        <a href="logout.php"><img src="https://img.icons8.com/ios-filled/24/000000/logout-rounded-left.png" alt="Logout Icon"> Logout</a>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Dashboard</h2>
                <button class="btn-add" onclick="location.href='add_contact.php'">+ Add Contact</button>
            </div>
            <div class="filters" style="margin: 20px 0;">
                <strong>Filter By:</strong>
                <a href="?filter=all"><button class="btn-filter">All</button></a>
                <a href="?filter=sales"><button class="btn-filter">Sales Leads</button></a>
                <a href="?filter=support"><button class="btn-filter">Support</button></a>
                <a href="?filter=assigned"><button class="btn-filter">Assigned to Me</button></a>
            </div>
            <table class="contact-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['company']); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td><a href="view_contact.php?id=<?php echo $row['id']; ?>">View</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: #888;">No contacts to display</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

<?php
$stmt->close();
$conn->close();

/*
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="https://e7.pngegg.com/pngimages/466/444/png-clipart-tattoo-flash-dolphin-cartoon-dolphin-marine-mammal-mammal.png" alt="Dolphin Logo" class="logo">
        <span class="header-text">Dolphin CRM</span>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="/Home/index.html" class="active"><img src="https://img.icons8.com/ios-filled/24/000000/home.png" alt="Home Icon"> Home</a>
        <a href="/Add-User/index.html"><img src="https://img.icons8.com/ios-filled/24/000000/add-contact-to-company.png" alt="New Contact Icon"> New Contact</a>
        <a href="/New-Contact/index.html"><img src="https://img.icons8.com/ios-filled/24/000000/user-group-man-man.png" alt="Users Icon"> Users</a>
        <a href="/Login/index.html"><img src="https://img.icons8.com/ios-filled/24/000000/logout-rounded-left.png" alt="Logout Icon"> Login</a>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Dashboard</h2>
                <button class="btn-add" onclick="location.href='#'">+ Add Contact</button>
            </div>
            <div class="filters" style="margin: 20px 0;">
                <strong>Filter By:</strong>
                <button class="btn-filter">All</button>
                <button class="btn-filter">Sales Leads</button>
                <button class="btn-filter">Support</button>
                <button class="btn-filter">Assigned to Me</button>
            </div>
            <table class="contact-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #888;">No contacts to display</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
*/
?>

