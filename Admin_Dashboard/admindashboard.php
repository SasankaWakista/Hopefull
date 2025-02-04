<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'head.php'; ?>
  
  <div class="container">
  
    <div class="login-image-container">
      <img src="images/login-image.jpeg" alt="Login Image">
  </div>

    <div class="grid">
      <div class="card">
        <h2>System Administrator</h2><br/>
        
        <a href="system_admin_login.html">Login</a>
      </div>

      <div class="card">
        <h2>Regional Officers</h2><br/>
        
        <a href="regional_officer_login.html">Login</a>
      </div>
      <div class="card">
        <h2>Authentication Moderators</h2>
        
        <a href="auth_moderator_login.html">Login</a>
      </div>
      
      <div class="card">
        <h2>Marketplace Managers</h2>
        
        <a href="market_manager_login.html">Login</a>
      </div>

    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>
</html>
