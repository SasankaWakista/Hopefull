<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['donate'])){
    $donation_id = $_POST['donation_id'];
    $donation_amount = $_POST['donation_amount'];

    // Fetch current donated amount
    $fetch_donated_amount = mysqli_query($conn, "SELECT amount_donated, total_amount FROM `donation_requests` WHERE id = '$donation_id'") or die('query failed');
    if(mysqli_num_rows($fetch_donated_amount) > 0){
        $donation_data = mysqli_fetch_assoc($fetch_donated_amount);
        $updated_amount = $donation_data['amount_donated'] + $donation_amount;

        if($updated_amount > $donation_data['total_amount']){
            $message[] = 'Donation exceeds required amount!';
        } else {
            mysqli_query($conn, "UPDATE `donation_requests` SET amount_donated = '$updated_amount' WHERE id = '$donation_id'") or die('query failed');
            $message[] = 'Thank you for your donation!';
        }
    } else {
        $message[] = 'Donation request not found!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Donation</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="quick-view">

    <h1 class="title">Donation Details</h1>

    <?php  
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $select_donation = mysqli_query($conn, "SELECT * FROM `donation_requests` WHERE id = '$id'") or die('query failed');
         if(mysqli_num_rows($select_donation) > 0){
            while($fetch_donation = mysqli_fetch_assoc($select_donation)){
    ?>
    <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_donation['image']; ?>" alt="Donation Image" class="image">
         <div class="name">Description: <?php echo $fetch_donation['description']; ?></div>
         <div class="price">Goal: $<?php echo $fetch_donation['total_amount']; ?> | Raised: $<?php echo $fetch_donation['amount_donated']; ?></div>
         <div class="details">Deadline: <?php echo $fetch_donation['deadline_date']; ?></div>
         <?php if($fetch_donation['proof_document']): ?>
         <div class="proof">Proof Document: <a href="uploaded_docs/<?php echo $fetch_donation['proof_document']; ?>" target="_blank">View Document</a></div>
         <?php endif; ?>
         <input type="number" name="donation_amount" value="1" min="1" class="qty">
         <input type="hidden" name="donation_id" value="<?php echo $fetch_donation['id']; ?>">
         <input type="submit" value="Donate Now" name="donate" class="btn">
      </form>
    <?php
            }
        }else{
        echo '<p class="empty">No donation details available!</p>';
        }
    }
    ?>

    <div class="more-btn">
        <a href="home.php" class="option-btn">Go to Home Page</a>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
