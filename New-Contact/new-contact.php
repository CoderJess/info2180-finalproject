<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a New Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="https://e7.pngegg.com/pngimages/466/444/png-clipart-tattoo-flash-dolphin-cartoon-dolphin-marine-mammal-mammal.png" alt="Dolphin Logo" class="logo">
        <span class="header-text">Dolphin CRM</span>
    </div>

     <!-- Sidebar -->
     <div class="sidebar">
        <a href="../Home/dashboard.php" class="active"><img src="https://img.icons8.com/ios-filled/24/000000/home.png" alt="Home Icon"> Home</a>
        <a href="new-contact.php"><img src="https://img.icons8.com/ios-filled/24/000000/add-contact-to-company.png" alt="New Contact Icon"> New Contact</a>
        <a href="../Users/view_users.php"><img src="https://img.icons8.com/ios-filled/24/000000/user-group-man-man.png" alt="Users Icon"> Users</a>
        <a href="../logout.php"><img src="https://img.icons8.com/ios-filled/24/000000/logout-rounded-left.png" alt="Logout Icon"> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="card">
            <h2>Create a New Contact</h2>
            <?php if (isset($feedback)): ?>
                <div class="feedback-message" style="color: red;"><?php echo htmlspecialchars($feedback); ?></div>
            <?php endif; ?>
            <form action="create_contact.php" method="POST">
                <!-- Title -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <select id="title" name="title" required>
                        <option value="">Select Title</option>
                        <option>Mr</option>
                        <option>Ms</option>
                        <option>Mrs</option>
                        <option>Dr</option>
                    </select>
                </div>
                <!-- First Name -->
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                </div>
                <!-- Last Name -->
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <!-- Telephone -->
                <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input type="tel" id="telephone" name="telephone" placeholder="Telephone" required>
                </div>
                <!-- Company -->
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" id="company" name="company" placeholder="Company" required>
                </div>
                <!-- Type -->
                <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option>Sales Lead</option>
                        <option>Support</option>
                    </select>
                </div>
                <!-- Assigned To -->
                <div class="form-group">
                    <label for="assignedTo">Assigned To</label>
                    <select id="assignedTo" name="assignedTo" required>
                        <option value="">Select a User</option>
                        <?php
                        // Fetch users from the database
                        include 'db.php';
                        $result = $conn->query("SELECT id, firstname, lastname FROM users");

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['firstname']} {$row['lastname']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn-save">Save</button>
            </form>
        </div>
    </div>
</body>
</html>

