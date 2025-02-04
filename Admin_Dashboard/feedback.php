<?php
session_start();

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
// Fetch feedback data
$query = "
    SELECT feedback.feedback_id, feedback.feedback_message, feedback.rating, users.name AS submitted_by
    FROM feedback
    JOIN users ON feedback.user_id = users.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback Management</title>
  <link rel="stylesheet" href="css/regional_officer.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Feedback Management</h1>
    <table>
      <thead>
        <tr>
          <th>Feedback ID</th>
          <th>Feedback Message</th>
          <th>Rating</th>
          <th>Submitted By</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
          <tr>
            <td><?php echo $row['feedback_id']; ?></td>
            <td><?php echo $row['feedback_message']; ?></td>
            <td><?php echo $row['rating']; ?></td>
            <td><?php echo $row['submitted_by']; ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
