<?php
$servername = "localhost"; // Database server
$username = "crm_user"; // Database username
$password = "password123"; // Database password
$dbname = "dolphin_crm"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>