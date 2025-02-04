<?php

@include 'config.php';
session_start();

if(isset($_GET['update'])){
   $update_id = $_GET['update'];
   
   // Fetch the existing donation request details
   $select_donation = mysqli_query($conn, "SELECT * FROM donation_requests WHERE id = '$update_id'") or die('query failed');
   $fetch_donation = mysqli_fetch_assoc($select_donation);

   if(isset($_POST['update_donation'])){
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
      $deadline_date = mysqli_real_escape_string($conn, $_POST['deadline_date']);
      $amount_donated = mysqli_real_escape_string($conn, $_POST['amount_donated']);
      
      // Initialize variables for new image and document
      $image = $_FILES['image']['name'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_img/'.$image;

      $proof_document = $_FILES['proof_document']['name'];
      $proof_tmp_name = $_FILES['proof_document']['tmp_name'];
      $proof_folder = 'uploaded_files/'.$proof_document;

      if(empty($description) || empty($total_amount) || empty($deadline_date)){
         $message[] = 'All fields are required!';
      } else {
         // Start building the update query
         $update_query = "UPDATE donation_requests SET description='$description', total_amount='$total_amount', deadline_date='$deadline_date'";

         // Check if new image is uploaded
         if(!empty($image)){
            $update_query .= ", image='$image'";
            move_uploaded_file($image_tmp_name, $image_folder);
         }

         // Check if new proof document is uploaded
         if(!empty($proof_document)){
            $update_query .= ", proof_document='$proof_document'";
            move_uploaded_file($proof_tmp_name, $proof_folder);
         }
         $update_query .= ", amount_donated='$amount_donated'"; 
         $update_query .= " WHERE id='$update_id'";

         if(mysqli_query($conn, $update_query)){
            $message[] = 'Donation request updated successfully!';
            header('Location: Recipient_requests.php');
            exit;
        } else {
            $message[] = 'Failed to update donation request!';
      }
    }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Donation</title>
   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom Admin CSS -->
   <link rel="stylesheet" href="stylePages/recipient_style.css">
   <style>
     .user-icon i {
            color: #901357;
        }

        .user-icon {
            position: relative;
            display: inline-block;
            cursor: pointer;
            margin-left: auto;
            margin-right: 20px; 
        }

        .user-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding: 10px;
            min-width: 230px;
        }

        .user-icon:hover .user-dropdown {
            display: block; /* Show dropdown on hover */
        }

        .user-dropdown a {
            display: block;
            color: black;
            text-decoration: none;
            padding: 8px 12px;
            text-align:center;
        }

        .user-dropdown a:hover {
            background-color: #901357;
            color: white;
        }

        .btn{
            margin-left:50px;
        }


    </style>
</head>
<body>

<header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logo.png" alt="Hopefull Logo">
            </div>
            <ul class="nav-links">
                <li class="hideOnMobile"><a href="Recipient_requests.php">Back</a></li>
                <li class="hideOnMobile"><a href="Recipient_login.php">Logout</a></li>
            </ul>
            <div class="user-icon">
            <i class="fas fa-user" style="font-size: 30px;"></i>
            <div class="user-dropdown">
                <span>Email : <?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                <a href="Recipient_Dashboard.php">My Dashboard</a> 
                <a href="Recipient_login.php">Logout</a>
            </div>
        </div>
        </nav>
    </header>

<section class="update-donation">
   <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateDeadlineDate()">
      <h3>Update Donation Request</h3>
      <textarea name="description" class="box" required placeholder="Enter donation description" cols="30" rows="5"><?php echo $fetch_donation['description']; ?></textarea>
      <input type="number" min="0" class="box" required placeholder="Enter donation goal amount" name="total_amount" value="<?php echo $fetch_donation['total_amount']; ?>">
      <input type="number" min="0" class="box" required placeholder="Enter amount raised" name="amount_donated" value="<?php echo $fetch_donation['amount_donated']; ?>">
      <input type="date" class="box" required name="deadline_date" value="<?php echo $fetch_donation['deadline_date']; ?>">
      <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image" placeholder="Upload donation image">
      <input type="file" accept=".pdf,.doc,.docx" class="box" name="proof_document" placeholder="Upload proof document">
      <input type="submit" value="Update Donation Request" name="update_donation" class="btn">
   </form>
</section>
<script>
    function validateDeadlineDate() {
    const deadlineInput = document.querySelector('input[name="deadline_date"]');
    const selectedDate = new Date(deadlineInput.value);
    const today = new Date();

    // Set the time of today to midnight for comparison
    today.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
        alert('Please select a valid date !');
        deadlineInput.focus();
        return false;
    }
    return true; // Valid date
}
</script>
</body>
</html>