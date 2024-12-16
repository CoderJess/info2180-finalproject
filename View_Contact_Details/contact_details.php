<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the contact ID from the query string
$contact_id = $_GET['id'] ?? null;

if ($contact_id === null) {
    echo "Contact not found.";
    exit();
}

// Fetch contact details
$stmt = $conn->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->bind_param('i', $contact_id);
$stmt->execute();
$contact = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch notes for the contact
$stmt = $conn->prepare("SELECT n.comment, n.created_at, u.email AS user_email FROM notes n JOIN users u ON n.user_id = u.id WHERE n.contact_id = ?");
$stmt->bind_param('i', $contact_id);
$stmt->execute();
$notes = $stmt->get_result();
$stmt->close();

// Handle form submission for assigning contact or changing type
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['assign'])) {
        // Assign to self
        $stmt = $conn->prepare("UPDATE contacts SET assigned_to = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param('si', $_SESSION['user_id'], $contact_id);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST['change_type'])) {
        // Change contact type
        $new_type = ($contact['type'] === 'Sales Lead') ? 'Support' : 'Sales Lead';
        $stmt = $conn->prepare("UPDATE contacts SET type = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param('si', $new_type, $contact_id);
        $stmt->execute();
        $stmt->close();
    }

    // Adding a new note
    if (isset($_POST['new_note'])) {
        $comment = $_POST['comment'];
        $stmt = $conn->prepare("INSERT INTO notes (contact_id, user_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param('iis', $contact_id, $_SESSION['user_id'], $comment);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to avoid resubmission
    header("Location: view_contact.php?id=$contact_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <h2>Contact Details</h2>
        <h3><?php echo htmlspecialchars($contact['title'] . ' ' . $contact['full_name']); ?></h3>
        <p>Email: <?php echo htmlspecialchars($contact['email']); ?></p>
        <p>Company: <?php echo htmlspecialchars($contact['company']); ?></p>
        <p>Telephone: <?php echo htmlspecialchars($contact['telephone']); ?></p>
        <p>Date Created: <?php echo htmlspecialchars($contact['created_at']); ?></p>
        <p>Last Updated: <?php echo htmlspecialchars($contact['updated_at']); ?></p>
        <p>Assigned To: <?php echo htmlspecialchars($contact['assigned_to']); ?></p>
        <p>Type: <?php echo htmlspecialchars($contact['type']); ?></p>

        <form action="" method="POST">
            <button name="assign">Assign to me</button>
            <button name="change_type"><?php echo $contact['type'] === 'Sales Lead' ? 'Switch to Support' : 'Switch to Sales Lead'; ?></button>
        </form>

        <h3>Notes</h3>
        <table>
            <tr>
                <th>User</th>
                <th>Comment</th>
                <th>Date Added</th>
            </tr>
            <?php while ($note = $notes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($note['user_email']); ?></td>
                    <td><?php echo htmlspecialchars($note['comment']); ?></td>
                    <td><?php echo htmlspecialchars($note['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h3>Add a Note</h3>
        <form action="" method="POST">
            <textarea name="comment" required></textarea>
            <button type="submit" name="new_note">Add Note</button>
        </form>
    </div>
</body>
</html>

<?php

$conn->close();
?>