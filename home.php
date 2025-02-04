<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

$select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php @include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Welcome To Hopefull</h3>
      <h4>For humanity. By humanity</h4>
      <p>Hopefull is a compassionate donation platform designed to bring hope and support to those in need. It connects donors with meaningful causes, enabling users to make impactful contributions easily and transparently.</p>
      <a href="Search.php" class="btn">discover more</a>
   </div>

</section>

<section class="donations">
    <h1 class="title">Latest Requests</h1>
    <div class="box-container">
    <?php
$select_requests = mysqli_query($conn, "SELECT * FROM `donation_requests` LIMIT 3") or die('query failed');
if(mysqli_num_rows($select_requests) > 0){
   while($fetch_requests = mysqli_fetch_assoc($select_requests)){
?>
<form action="" method="POST" class="box">
   <a href="donation.php?rid=<?php echo $fetch_requests['id']; ?>" class="fas fa-eye"></a>
   
   
   <!-- Display uploaded image -->
   <img src="Recipient/uploaded_img/<?php echo $fetch_requests['image']; ?>" alt="Request Image" class="image">

   <div class="name"><?php echo $fetch_requests['description']; ?></div>
   <div class="date">Deadline: <?php echo $fetch_requests['deadline_date']; ?></div>
   <div class="price">Total: Rs.<?php echo $fetch_requests['total_amount']; ?></div>
   <div class="price">Raised: Rs.<?php echo $fetch_requests['amount_donated']; ?></div>
  
   <input type="hidden" name="request_id" value="<?php echo $fetch_requests['id']; ?>">
</form>
<?php
   }
} else {
   echo '<p class="empty">No active donation requests found!</p>';
}
?>

    </div>
</section>


<section class="market">
    
   <div class="content">
      <h3>Marketplace</h3>
      <p>Shop for a cause. Every purchase you make helps support a cause you care about.</p>
      <a href="hopefullmarketplace/login.php" class="btn">shop now</a>
   </div>
</section>


<section class="gallery">
        <h2>Gallery</h2>
        <div class="gallery-slideshow">
            <div class="gallery-slide fade">
                <img src="images/gallery1.jpg" alt="Gallery Image 1">
            </div>
            <div class="gallery-slide fade">
                <img src="images/gallery2.jpg" alt="Gallery Image 2">
            </div>
            <div class="gallery-slide fade">
                <img src="images/gallery3.jpg" alt="Gallery Image 3">
            </div>

            
        </div>
        <div class="gallery-nav">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
        </div>
    </section>


<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>At Hopefull, we're here to assist with any questions or concerns you may have. Whether you're a donor or recipient, feel free to reach out to us for support. Together, we can make a difference!</p>
      <a href="contact.php" class="btn">contact us</a>
   </div>

</section>

<?php @include 'footer.php'; ?>



<script src="js/script.js"></script>

</body>
</html>