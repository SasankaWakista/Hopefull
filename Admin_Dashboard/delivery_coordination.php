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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickup_location = $_POST['pickup_location'];
    $delivery_schedule = $_POST['delivery_schedule'];
    $recipient = $_POST['recipient'];

    // Insert into deliveries table
    $query = "INSERT INTO deliveries (pickup_location, delivery_schedule, recipient) 
              VALUES ('$pickup_location', '$delivery_schedule', '$recipient')";
    if (mysqli_query($conn, $query)) {
        echo "Delivery scheduled successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery Coordination</title>
  <link rel="stylesheet" href="css/regional_officer.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Delivery Coordination</h1>
    <form action="delivery_coordination.php" method="POST">
      <label for="pickup_location">Pickup Location</label>
      <input type="text" name="pickup_location" id="pickup_location" required>

      <label for="delivery_schedule">Delivery Schedule</label>
      <input type="datetime-local" name="delivery_schedule" id="delivery_schedule" required>

      <label for="recipient">Recipient</label>
      <input type="text" name="recipient" id="recipient" required>

      <button type="submit">Schedule Delivery</button>
    </form>
  </div>
</body>
</html>
