<?php
session_start();

// Check if the user is logged in and has the 'Authentication Moderator' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Authentication Moderator') {
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
            <p>You are not an authentication moderator.</p>
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

// Query to get the number of pending recipient registrations and total recipient requests
$pending_requests_query = "SELECT COUNT(*) AS pending_requests FROM recipient_requests WHERE status = 'Pending'";
$total_requests_query = "SELECT COUNT(*) AS total_requests FROM recipient_requests";

$pending_requests_result = $conn->query($pending_requests_query);
$total_requests_result = $conn->query($total_requests_query);

$pending_requests = $pending_requests_result->fetch_assoc()['pending_requests'];
$total_requests = $total_requests_result->fetch_assoc()['total_requests'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authentication Moderator Dashboard</title>
  <link rel="stylesheet" href="css/admin_interface.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

  <div class="container">
    <h1>Authentication Moderator Dashboard</h1>

    <div class="grid">
      <div class="card">
        <h2>Pending Recipient Registrations</h2>
          <p><?php echo $total_requests; ?></p>
      </div>
      <div class="card">
      <h2>Pending Recipient Requests</h2></br>
      <p><?php echo $pending_requests; ?></p>
      </div>
    </div>
    <div class="grid">

      <!-- Existing Dashboard Cards -->
      <div class="card">
        <h2>Approve/Reject Recipient Registrations</h2><br/>
        <a href="view_requests.php">Registrations Requests</a>
      </div>

      <div class="card">
        <h2>View Recipient Requests</h2><br/><br/>
        <a href="recipient_registration.php">Recipient Requests</a>
      </div>

      <div class="card">
        <h2>Communicate with Recipients</h2><br/><br/>
        <a href="communicate.php">Send a Message</a>
      </div>

      
      

    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
