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

// Fetch inventory data
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Management</title>
  <link rel="stylesheet" href="css/regional_officer.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <h1>Donated Inventory Management</h1>
  <table border="1">
    <thead>
      <tr>
        <th>Item Name</th>
        <th>Available Quantity</th>
        <th>Location</th>
        <th>Last Updated</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['item_name']; ?></td>
          <td><?php echo $row['available_quantity']; ?></td>
          <td><?php echo $row['location']; ?></td>
          <td><?php echo $row['last_updated']; ?></td>
          <td>
            <form action="update_inventory.php" method="POST">
              <input type="hidden" name="inventory_id" value="<?php echo $row['inventory_id']; ?>">
              <input type="number" name="quantity" placeholder="Enter new quantity" required>
              <button type="submit">Update</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>
