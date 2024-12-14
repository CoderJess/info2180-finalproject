<?php

session_start();
include 'db.php'; // Include database connection

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: Home/dashboard.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user_id;
            header('Location: Home/dashboard.php');
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dolphin CRM | Login</title>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <img src="https://e7.pngegg.com/pngimages/466/444/png-clipart-tattoo-flash-dolphin-cartoon-dolphin-marine-mammal-mammal.png" alt="Dolphin Logo" class="logo">
        <span class="header-text">Dolphin CRM</span>
    </div>

    <!-- Login Box -->
    <div class="login-box">
        <div class="login-header">
            <header>Login</header>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message" style="color: red;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="input-box">
                <input type="text" name="email" class="input-field" placeholder="Email Address" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="input-field" placeholder="Password" autocomplete="off" required>
            </div>
            <div class="input-submit">
                <button class="submit-btn" type="submit">Login</button>
            </div>
        </form>
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        Copyright &copy; 2024 Dolphin CRM
    </footer>
</body>
</html>

<?php
$conn->close();

/*
session_start();

if (isset($_SESSION['id'])){
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Store session variables
            $_SESSION['user_id'] = $user_id;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid password.';
        }
    } else {
        $error = 'No user found with that email address.';
    }

    $stmt->close();
}*/
?>