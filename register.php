<?php

@include 'config.php';

if (isset($_POST['submit'])) {

    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = password_hash($filter_pass, PASSWORD_DEFAULT);
    $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

    // Check if the user exists
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
    } else {
        if (!password_verify($filter_cpass, $pass)) {
            $message[] = 'Passwords do not match!';
        } else {
            mysqli_query($conn, "INSERT INTO `users` (name, email, password, user_type) VALUES ('$name', '$email', '$pass', 'user')") or die('query failed');
            $message[] = 'Registered successfully!';
            header('location:login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php @include 'login_header.php'; ?>

<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
           <span>' . $message . '</span>
           <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<div class="container">
  <div class="image-section">
    <img src="images/login.jpeg" alt="Image">
  </div>
  <div class="form-section">
    <h2>Register as a Donor/Volunteer</h2>
    <form action="" method="post">
      <input type="text" name="name" placeholder="Enter your name" required>
      <input type="email" name="email" placeholder="Enter your email" required>
      <input type="password" name="pass" placeholder="Enter your password" required>
      <input type="password" name="cpass" placeholder="Confirm your password" required>
      <button type="submit" name="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login now</a></p>
  </div>
</div>

</body>
</html>
