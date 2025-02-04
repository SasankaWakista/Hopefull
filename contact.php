<?php

@include 'config.php';

session_start();

// Retrieve user_id from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;



if (isset($_POST['send'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    // Check if the message already exists in the database
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('Query failed');

    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'Message has already been sent!';
    } else {
        // Use $user_id if available, otherwise set it to NULL
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES(" . ($user_id ? "'$user_id'" : "NULL") . ", '$name', '$email', '$number', '$msg')") or die('Query failed');
        $message[] = 'Message sent successfully!';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="contact">
    <form action="" method="POST">
        <h3>Send us a message!</h3>
        <label for="name">Name</label>
        <input type="text" name="name" class="box" required> 

        <label for="email">Email</label>
        <input type="email" name="email" class="box" required>

        <label for="number">Telephone Number</label>
        <input type="number" name="number" class="box" required>

        <label for="message">Message</label>
        <textarea name="message" class="box" required cols="30" rows="10"></textarea>
        <input type="submit" value="Send Message" name="send" class="btn">
    </form>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
