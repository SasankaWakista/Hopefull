<?php
session_start();

// Check if the user is logged in and has the 'System Admin' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'System Admin') {
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
            <p>You are not a system administrator.</p>
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

// Get counts for the dashboard
$sql_total_users = "SELECT COUNT(*) AS total_users FROM users";
$sql_admin_users = "SELECT COUNT(*) AS admin_users FROM admin_users";
$sql_issue_reports = "SELECT COUNT(*) AS total_reports FROM issue_reports";
$sql_banned_users = "SELECT COUNT(*) AS banned_users FROM admin_users WHERE status='banned'";

$total_users_result = $conn->query($sql_total_users);
$admin_users_result = $conn->query($sql_admin_users);
$issue_reports_result = $conn->query($sql_issue_reports);
$banned_users_result = $conn->query($sql_banned_users);

$total_users = $total_users_result->fetch_assoc()['total_users'];
$admin_users = $admin_users_result->fetch_assoc()['admin_users'];
$total_reports = $issue_reports_result->fetch_assoc()['total_reports'];
$banned_users = $banned_users_result->fetch_assoc()['banned_users'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin_interface.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

  
</head>
<body>
<?php include 'header.php'; ?>

  <div class="container">
    <h1>System Admin Dashboard</h1>
    

    <div class="grid">
      <div class="card">
        <h2>Donor Accounts</h2>
        <p><?php echo $total_users; ?></p>
      </div>
      <div class="card">
        <h2>Total Admin Accounts</h2>
        <p><?php echo $admin_users; ?></p>
      </div>
      <div class="card">
        <h2>Messages Received</h2>
        <p><?php echo $total_reports; ?></p>
      </div>
      <div class="card">
        <h2>Total Banned Accounts</h2>
        <p><?php echo $banned_users; ?></p>
      </div>
    </div>

    <div class="grid">
      <!-- User Profile Management -->
      <div class="card">
        <h2>User Profile Management</h2>
        <a href="admin_profile_management.php">Manage Profiles</a>
      </div>

      <!-- Handle Issue Reports -->
      <div class="card">
        <h2>Messages Received</h2>
        <a href="issue_reports.php">View Messages</a>
      </div>

      <!-- Ban Accounts -->
      <div class="card">
        <h2>Ban/Unban Accounts</h2>
        <a href="ban_unban_accounts.php">Manage Bans</a>
      </div>

      <!-- Communicate with Users -->
      <div class="card">
        <h2>Communicate with Users</h2>
        <a href="communicate.php">Send Messages</a>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  
</body>
</html>
