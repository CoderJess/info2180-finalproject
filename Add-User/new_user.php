<?php

session_start();
include 'db.php'; // Include database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate input
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss', $firstName, $lastName, $email, $hashedPassword, $role);

            if ($stmt->execute()) {
                header('Location: Home/dashboard.php'); // Redirect to dashboard after successful registration
                exit();
            } else {
                $error = "Error registering user. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolphin CRM - New User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <img src="https://e7.pngegg.com/pngimages/466/444/png-clipart-tattoo-flash-dolphin-cartoon-dolphin-marine-mammal-mammal.png" alt="Dolphin Logo" class="logo">
        <span class="header-text">Dolphin CRM</span>
    </div>

    <div class="sidebar">
        <a href="../Home/dashboard.php" class="active"><img src="https://img.icons8.com/ios-filled/24/000000/home.png" alt="Home Icon"> Home</a>
        <a href="../New-Contact/new_contact.php"><img src="https://img.icons8.com/ios-filled/24/000000/add-contact-to-company.png" alt="New Contact Icon"> New Contact</a>
        <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/user-group-man-man.png" alt="Users Icon"> Users</a>
        <a href="../logout.php"><img src="https://img.icons8.com/ios-filled/24/000000/logout-rounded-left.png" alt="Logout Icon"> Logout</a>
    </div>

    <div class="main">
        <div class="card">
            <h2>New User</h2>

            <?php if (isset($error)): ?>
                <div class="error-message" style="color: red;"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Jane" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Doe" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="something@example.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="Member">Member</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn-save">Save</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();

?>
