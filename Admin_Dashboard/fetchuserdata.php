<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hopefull_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users for profile management
$sql = "SELECT id, username, email, role, status FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
                <td>{$row['role']}</td>
                <td>{$row['status']}</td>
                <td><button>Update</button><button>Delete</button></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No users found</td></tr>";
}

$conn->close();
?>
