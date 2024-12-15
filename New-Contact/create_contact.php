<?php
session_start();
include 'db.php'; // Include database connection

$feedback = ''; // Initialize feedback variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize it
    $title = htmlspecialchars(trim($_POST['title']));
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $company = htmlspecialchars(trim($_POST['company']));
    $type = htmlspecialchars(trim($_POST['type']));
    $assignedTo = htmlspecialchars(trim($_POST['assignedTo']));

    // Validate inputs
    if (empty($title) || empty($firstName) || empty($lastName) || empty($email) ||
        empty($telephone) || empty($company) || empty($type) || empty($assignedTo)) {
        $feedback = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedback = "Invalid email format.";
    } else {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $created_by = $_SESSION['user_id']; // Assuming user_id is stored in session

        if ($stmt) {
            $stmt->bind_param('ssssssssi', $title, $firstName, $lastName, $email, $telephone, $company, $type, $assignedTo, $created_by);

            if ($stmt->execute()) {
                $feedback = "Contact added successfully.";
            } else {
                $feedback = "Error adding contact: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $feedback = "Database error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!-- Redirect back to the contact creation page -->
<script>
    window.location.href = 'create_contact_form.php?feedback=<?php echo urlencode($feedback); ?>';
</script>