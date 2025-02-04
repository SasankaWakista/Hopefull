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

// Fetch shipment tracking data
$sql = "SELECT * FROM shipment_tracking";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shipment Tracking</title>
  <link rel="stylesheet" href="css/regional_officer.css">
</head>
<body>
  <h1>Donations Tracking</h1>
  <table border="1">
    <thead>
      <tr>
        <th>Shipment ID</th>
        <th>Donation ID</th>
        <th>Status</th>
        <th>Estimated Delivery</th>
        <th>Actual Delivery</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['shipment_id']; ?></td>
          <td><?php echo $row['donation_id']; ?></td>
          <td><?php echo $row['tracking_status']; ?></td>
          <td><?php echo $row['estimated_delivery_date']; ?></td>
          <td><?php echo $row['actual_delivery_date']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>
