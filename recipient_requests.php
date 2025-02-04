<?php

@include 'config.php';

session_start();



if(isset($_POST['add_donation'])){

   $description = mysqli_real_escape_string($conn, $_POST['description']);
   $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
   $deadline_date = mysqli_real_escape_string($conn, $_POST['deadline_date']);
   
   $image = $_FILES['image']['name'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $proof_document = $_FILES['proof_document']['name'];
   $proof_tmp_name = $_FILES['proof_document']['tmp_name'];
   $proof_folder = 'uploaded_files/'.$proof_document;

   if(empty($description) || empty($total_amount) || empty($deadline_date) || empty($image) || empty($proof_document)){
      $message[] = 'All fields are required!';
   }else{
      $insert_donation = mysqli_query($conn, "INSERT INTO `donation_requests` (description, total_amount, deadline_date, image, proof_document, amount_donated) VALUES ('$description', '$total_amount', '$deadline_date', '$image', '$proof_document', 0)") or die('query failed');
      
      if($insert_donation){
         move_uploaded_file($image_tmp_name, $image_folder);
         move_uploaded_file($proof_tmp_name, $proof_folder);
         $message[] = 'Donation request added successfully!';
      }else{
         $message[] = 'Failed to add donation request!';
      }
   }
}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete = mysqli_query($conn, "SELECT * FROM `donation_requests` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete = mysqli_fetch_assoc($select_delete);
   unlink('uploaded_img/'.$fetch_delete['image']);
   unlink('uploaded_files/'.$fetch_delete['proof_document']);
   mysqli_query($conn, "DELETE FROM `donation_requests` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_donations.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Donations</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom Admin CSS -->
   <link rel="stylesheet" href="css/recipient_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-donations">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add New Donation Request</h3>
      <textarea name="description" class="box" required placeholder="Enter donation description" cols="30" rows="5"></textarea>
      <input type="number" min="0" class="box" required placeholder="Enter donation goal amount" name="total_amount">
      <input type="date" class="box" required name="deadline_date">
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image" placeholder="Upload donation image">
      <input type="file" accept=".pdf,.doc,.docx" required class="box" name="proof_document" placeholder="Upload proof document">
      <input type="submit" value="Add Donation Request" name="add_donation" class="btn">
   </form>

</section>

<section class="show-donations">

   <div class="box-container">

      <?php
         $select_donations = mysqli_query($conn, "SELECT * FROM `donation_requests`") or die('query failed');
         if(mysqli_num_rows($select_donations) > 0){
            while($fetch_donations = mysqli_fetch_assoc($select_donations)){
      ?>
      <div class="box">
         <div class="goal">Goal: $<?php echo $fetch_donations['total_amount']; ?></div>
         <div class="raised">Raised: $<?php echo $fetch_donations['amount_donated']; ?></div>
         <img class="image" src="uploaded_img/<?php echo $fetch_donations['image']; ?>" alt="">
         <div class="description"><?php echo $fetch_donations['description']; ?></div>
         <div class="deadline">Deadline: <?php echo $fetch_donations['deadline_date']; ?></div>
         <a href="uploaded_files/<?php echo $fetch_donations['proof_document']; ?>" target="_blank" class="btn">View Proof</a>
         <a href="admin_update_donation.php?update=<?php echo $fetch_donations['id']; ?>" class="option-btn">Update</a>
         <a href="admin_donations.php?delete=<?php echo $fetch_donations['id']; ?>" class="delete-btn" onclick="return confirm('Delete this donation request?');">Delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No donation requests added yet!</p>';
      }
      ?>
   </div>
   
</section>

<script src="js/admin_script.js"></script>

</body>
</html>
