<?php
session_start();

// Check if the user is logged in and has the 'regional officer' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Regional Officer') {
    // Display an error message and terminate the script
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Access Denied</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f8d7da;
                color: #721c24;
            }
            .message-container {
                text-align: center;
                border: 1px solid #f5c6cb;
                background-color: #f8d7da;
                padding: 20px;
                border-radius: 5px;
            }
            .message-container h1 {
                margin: 0 0 10px;
                font-size: 24px;
            }
            .message-container p {
                margin: 0;
                font-size: 18px;
            }
        </style>
    </head>
    <body>
        <div class='message-container'>
            <h1>Access Denied</h1>
            <p>You are not a Regional Officer.</p>
        </div>
    </body>
    </html>";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hopefull_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the number of donations made, to be received, and pending donations
$donations_made_query = "SELECT COUNT(*) AS donations_made FROM donations WHERE status = 'Completed'";
$donations_received_query = "SELECT COUNT(*) AS donations_received FROM donations WHERE status = 'Received'";
$pending_donations_query = "SELECT COUNT(*) AS pending_donations FROM donations WHERE status = 'Pending'";

$donations_made_result = $conn->query($donations_made_query);
$donations_received_result = $conn->query($donations_received_query);
$pending_donations_result = $conn->query($pending_donations_query);

$donations_made = $donations_made_result->fetch_assoc()['donations_made'];
$donations_received = $donations_received_result->fetch_assoc()['donations_received'];
$pending_donations = $pending_donations_result->fetch_assoc()['pending_donations'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regional Officer Dashboard</title>
  <link rel="stylesheet" href="css/admin_interface.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

  <div class="container">
    <h1>Regional Officer Dashboard</h1>
<div class="grid">
    <div class="card">
        <h2>Donations Made</h2></br>
        <p><?php echo $donations_made; ?></p>
      </div>
      <div class="card">
        <h2>Donations Received</h2>
        <p><?php echo $donations_received; ?></p>
      </div>
      <div class="card">
        <h2>Pending Donations</h2></br>
        <p><?php echo $pending_donations; ?></p>
    </div>  
</div>
    <div class="grid">

      <!-- Existing Dashboard Cards -->
      <div class="card">
        <h2>Manage Donations</h2><br/>
        <a href="manage_donations.php">View Details</a>
      </div>

      <div class="card">
        <h2>Donations Tracking</h2><br/>
        <a href="shipment_tracking.php">Track Donations</a>
      </div>

      <div class="card">
        <h2>Donated Inventory Updates</h2>
        <a href="inventory_management.php">View Inventory</a>
      </div>   

      <div class="card">
        <h2>Communicate with Users</h2><br/>
        <a href="communicate.php">Send Messages</a>
      </div>    

     


    </div>
  </div>
  
  <?php include 'footer.php'; ?>
</body>
</html>
