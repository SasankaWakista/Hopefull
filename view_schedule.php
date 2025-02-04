<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM `non_monetary_schedules` WHERE id = '$delete_id' AND user_id = '$user_id'";
    if (mysqli_query($conn, $delete_query)) {
        $message = "Schedule deleted successfully!";
    } else {
        $message = "Failed to delete schedule!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Schedules</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php @include 'header.php'; ?>

<section class="placed-orders">

    <h1 class="title">Scheduled Donations</h1>

    <?php if (isset($message)) { ?>
        <div class="message">
            <p><?php echo $message; ?></p>
        </div>
    <?php } ?>

    <div class="box-container">

    <?php
        $select_schedules = mysqli_query($conn, "SELECT * FROM `non_monetary_schedules` WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_schedules) > 0) {
            while ($fetch_schedule = mysqli_fetch_assoc($select_schedules)) {
    ?>
    <div class="box">
        <p> Scheduled On: <span><?php echo $fetch_schedule['created_at']; ?></span> </p>
        <p> Donation ID: <span><?php echo $fetch_schedule['donation_id']; ?></span> </p>
        <p> Donor Name: <span><?php echo $fetch_schedule['donor_name']; ?></span> </p>
        <p> Quantity: <span><?php echo $fetch_schedule['quantity']; ?></span> </p>
        <p> Drop-off Location: <span><?php echo $fetch_schedule['drop_off_location']; ?></span> </p>
        <p> Drop-off Time: <span><?php echo $fetch_schedule['drop_off_time']; ?></span> </p>
        <p> Status: <span style="color:<?php if ($fetch_schedule['status'] == 'Pending') { echo 'tomato'; } else { echo 'green'; } ?>"><?php echo $fetch_schedule['status']; ?></span> </p>
        <a href="update_schedule.php?schedule_id=<?php echo $fetch_schedule['id']; ?>" class="btn">Update Schedule</a>
        <a href="view_schedule.php?delete_id=<?php echo $fetch_schedule['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this schedule?');">Delete Schedule</a>
    </div>
    <?php
            }
        } else {
            echo '<p class="empty">No schedules found!</p>';
        }
    ?>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
