<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    // Sanitize and validate user inputs
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

    // Check if the user exists
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);

        // Check if the password matches using bcrypt
        if (password_verify($filter_pass, $row['password'])) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('Location: Admin_Dashboard/AdminDashboard.php');
                exit();
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('Location: home.php');
                exit();
            } else {
                $message[] = 'User type not recognized!';
            }
        } else {
            $message[] = 'Incorrect email or password!';
        }
    } else {
        $message[] = 'No user found!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php @include 'login_header.php'; ?>

<div class="container">
   <div class="image-section">
      <img src="images/login.jpeg" alt="Image">
   </div>
   <div class="form-section">
      <h2>Login as a Donor/Volunteer</h2>
      <form action="" method="post">
         <input type="email" name="email" placeholder="Email" required>
         <input type="password" name="pass" placeholder="Password" required>
         <button type="submit" name="submit">Login</button>
      </form>
      <p>Don't have an account? <a href="r_selection.php">Register now</a></p>
   </div>
</div>
</body>
</html>
