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

// Fetch donations data
$sql = "SELECT * FROM donations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Donations</title>
  <link rel="stylesheet" href="css/regional_officer.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <h1>Manage Donations</h1>
  <table border="1">
    <thead>
      <tr>
        <th>Donation ID</th>
        <th>Donor</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['donation_id']; ?></td>
          <td><?php echo $row['donor_user_id']; ?></td>
          <td><?php echo $row['item_name']; ?></td>
          <td><?php echo $row['quantity']; ?></td>
          <td><?php echo $row['status']; ?></td>
          <td>
            <form action="update_donation.php" method="POST">
              <input type="hidden" name="donation_id" value="<?php echo $row['donation_id']; ?>">
              <select name="status">
                <option value="Collected">Collected</option>
                <option value="Stored">Stored</option>
                <option value="Distributed">Distributed</option>
              </select>
              <button type="submit">Update</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>
