<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Selection</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php @include 'login_header.php'; ?>

<div class="container">
   <!-- Image Section -->
   <div class="image-section">
      <img src="images/login.jpeg" alt="Selection Image">
   </div>

   <!-- Selection Section -->
   <div class="form-section">
      <h2>Are you a Donor or a Recipient?</h2>
      <div class="selection-buttons">
         <a href="Register.php" class="btn donor-btn">Rgister as Donor</a>
         <a href="Recipient/Recipient_register.php" class="btn recipient-btn">Register as Recipient</a>
      </div>
      <p>New here? <a href="register.php">Register now</a></p>
   </div>
</div>

</body>
</html>
