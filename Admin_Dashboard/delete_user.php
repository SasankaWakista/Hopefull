<?php
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

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete the user from the database
    $sql = "DELETE FROM admin_users WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: admin_profile_management.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "User ID not provided!";
}

$conn->close();
?>
