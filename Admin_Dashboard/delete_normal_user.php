<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hopefull_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $delete_sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($delete_sql) === TRUE) {
        header("Location: user_profile_management.php"); // Success message for delete
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    die("Invalid request.");
}

$conn->close();
?>
