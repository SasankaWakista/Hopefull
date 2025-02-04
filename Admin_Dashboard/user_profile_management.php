<?php
// Start the session to access session variables
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



// Add user functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $status = $conn->real_escape_string($_POST['status']);

    $add_user_sql = "INSERT INTO users (name, email, status) VALUES ('$name', '$email', '$status')";

    if ($conn->query($add_user_sql) === TRUE) {
        // Redirect to the same page to prevent resubmission
        header("Location: user_profile_management.php?success=1");
        exit();
    } else {
        echo "Error: " . $add_user_sql . "<br>" . $conn->error;
    }
}

// Fetch user data
$sql = "SELECT id, name, email, status FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile Management</title>
  <link rel="stylesheet" href="css/user_profile_management.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="back-button">
    <a href="system_admin_interface.php">
      <button style="margin-bottom: 20px;">Back</button>
    </a>
  </div>
  <div class="container">
    <h1>User Profile Management</h1>

    <?php
    // Success message after redirection
    if (isset($_GET['success'])) {
        echo "<p style='color: green;'>User added successfully!</p>";
    }
    ?>

    <!-- Add User Form -->
    <div class="add-user-form">
      <h2>Add New User</h2>
      <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="status">Status:</label>
        <select id="status" name="status">
          <option value="Active">Active</option>
          <option value="Banned">Banned</option>
        </select>
  </br></br>
        <button type="submit" name="add_user">Add User</button>
      </form>
    </div>
  </br>
    <!-- User Table -->
    <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Check if there are any rows to display
        if ($result->num_rows > 0) {
            // Output data for each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>";

                // Update Button
                echo "<a href='update_normal_user.php?id=" . $row["id"] . "'><button>Update</button></a>";

                echo "<a href='delete_normal_user.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure you want to delete this user?');\"><button>Delete</button></a>";



                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No users found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <?php
  // Close the database connection
  $conn->close();
  ?>
</body>
</html>
