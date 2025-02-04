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

// Fetch shipment tracking data
$query = "
    SELECT shipment_id, tracking_number, current_status, estimated_delivery, origin, destination
    FROM shipments";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shipment Tracking</title>
  <link rel="stylesheet" href="css/regional_officer.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Marketplace Delivery Tracking</h1>
    <table>
      <thead>
        <tr>
          <th>Shipment ID</th>
          <th>Tracking Number</th>
          <th>Current Status</th>
          <th>Estimated Delivery</th>
          <th>Origin</th>
          <th>Destination</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
          <tr>
            <td><?php echo $row['shipment_id']; ?></td>
            <td><?php echo $row['tracking_number']; ?></td>
            <td><?php echo $row['current_status']; ?></td>
            <td><?php echo $row['estimated_delivery']; ?></td>
            <td><?php echo $row['origin']; ?></td>
            <td><?php echo $row['destination']; ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
