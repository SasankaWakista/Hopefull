<?php
session_start();

// Check if the user is logged in and has the 'Logistics' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Logistics') {
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
            <p>You are not a logistics officer.</p>
        </div>
    </body>
    </html>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logistics Dashboard</title>
  <link rel="stylesheet" href="css/admin_interface.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Marketplace Manager Dashboard</h1>
    
    <div class="grid">

      <div class="card">
        <h2>Manage Your Products</h2>
        <a href="product_management.php">Go to Products</a>
      </div>

      <div class="card">
        <h2>Manage Orders</h2><br/>
        <a href="seller_orders.php">Go to Orders</a>
      </div>
      
    </div>
    
  </div>
</body>
</html>
