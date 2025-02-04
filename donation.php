<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['donate'])) {
    $donation_id = $_POST['donation_id'];
    $donation_amount = $_POST['donation_amount'];

    // Fetch current donated amount
    $fetch_donated_amount = mysqli_query($conn, "SELECT amount_donated, total_amount FROM `donation_requests` WHERE id = '$donation_id'") or die('query failed');
    if (mysqli_num_rows($fetch_donated_amount) > 0) {
        $donation_data = mysqli_fetch_assoc($fetch_donated_amount);
        $updated_amount = $donation_data['amount_donated'] + $donation_amount;

        if ($updated_amount > $donation_data['total_amount']) {
            $message[] = 'Donation exceeds required amount!';
        } else {
            mysqli_query($conn, "UPDATE `donation_requests` SET amount_donated = '$updated_amount' WHERE id = '$donation_id'") or die('query failed');
            $message[] = 'Thank you for your donation!';
        }
    } else {
        $message[] = 'Donation request not found!';
    }
}

if (isset($_POST['schedule'])) {
    $donation_id = $_POST['donation_id'];
    $quantity = $_POST['quantity'];

    // Handle non-monetary donation scheduling
    $message[] = 'Thank you for scheduling your donation!';
    // Add further functionality as needed
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Donations</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS File -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="donations">

   <h1 class="title">Current Requests</h1>

   <div class="box-container">

      <?php
         $select_donations = mysqli_query($conn, "SELECT * FROM `donation_requests`") or die('query failed');
         if (mysqli_num_rows($select_donations) > 0) {
            while ($fetch_donations = mysqli_fetch_assoc($select_donations)) {
      ?>
      <form action="" method="POST" class="box">
         <img src="Recipient/uploaded_img/<?php echo $fetch_donations['image']; ?>" alt="Donation Image" class="image">
         <div class="name"><?php echo $fetch_donations['description']; ?></div>
         <div class="date">Deadline: <?php echo $fetch_donations['deadline_date']; ?></div>
         <?php if ($fetch_donations['donation_type'] == 'Monetary') { ?>
            <div class="goal">Goal: Rs.<?php echo $fetch_donations['total_amount']; ?></div>
            <div class="raised">Raised: Rs.<?php echo $fetch_donations['amount_donated']; ?></div>
            <input type="hidden" name="donation_id" value="<?php echo $fetch_donations['id']; ?>">
            <input type="number" name="donation_amount" value="1" min="1" class="qty">
            <input type="submit" value="Donate Now" name="donate" class="btn">
         <?php } else { ?>
            <div class="goal">Quantity Required: <?php echo $fetch_donations['quantity']; ?></div>
            <input type="hidden" name="donation_id" value="<?php echo $fetch_donations['id']; ?>">
            <input type="number" name="quantity" value="1" min="1" class="qty">
            <input type="submit" value="Schedule" name="schedule" class="btn" formaction="schedule.php?donation_id=<?php echo $fetch_donations['id']; ?>">

         <?php } ?>
         <div class="proof">
            <a href="Recipient/uploaded_files/<?php echo $fetch_donations['proof_document']; ?>" target="_blank" class="proof-btn">View Proof Document</a>
         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No donation requests found!</p>';
      }
      ?>

   </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
