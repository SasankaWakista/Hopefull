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
    $user_id = intval($_GET['id']); // Ensure ID is an integer

    // Fetch the user's current details
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Update the user profile with new data
            $name = $conn->real_escape_string($_POST['name']);
            $email = $conn->real_escape_string($_POST['email']);
            $status = $conn->real_escape_string($_POST['status']);

            // Prepared statement for updating
            $update_stmt = $conn->prepare("UPDATE admin_users SET name = ?, email = ?, status = ? WHERE id = ?");
            $update_stmt->bind_param("sssi", $name, $email, $status, $user_id);

            if ($update_stmt->execute()) {
                // Redirect after successful update
                header("Location: admin_profile_management.php");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    } else {
        echo "User not found!";
        exit();
    }
} else {
    echo "User ID not provided!";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update User Profile</title>
  <link rel="stylesheet" href="css/user_profile_management.css">
</head>
<body>
  <div class="container">
    <h1>Update User Profile</h1>
    <form method="POST">
      <label for="name">Username:</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

      <label for="role">Role:</label>
      <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" readonly> <!-- Role is read-only -->

      <label for="status">Status:</label>
      <select id="status" name="status" required>
        <option value="Active" <?php if ($user['status'] == 'Active') echo 'selected'; ?>>Active</option>
        <option value="Banned" <?php if ($user['status'] == 'Banned') echo 'selected'; ?>>Banned</option>
      </select>

      <button type="submit">Update</button>
    </form>
  </div>
</body>
</html>
