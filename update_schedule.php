<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
}

$schedule_id = $_GET['schedule_id'];

if (isset($_POST['update'])) {
    $drop_off_location = mysqli_real_escape_string($conn, $_POST['drop_off_location']);
    $drop_off_time = mysqli_real_escape_string($conn, $_POST['drop_off_time']);

    $update_query = "UPDATE `non_monetary_schedules` SET drop_off_location = '$drop_off_location', drop_off_time = '$drop_off_time' WHERE id = '$schedule_id'";
    if (mysqli_query($conn, $update_query)) {
        $message[] = 'Schedule updated successfully!';
    } else {
        $message[] = 'Failed to update schedule: ' . mysqli_error($conn);
    }
}

$schedule_query = mysqli_query($conn, "SELECT * FROM `non_monetary_schedules` WHERE id = '$schedule_id'") or die('query failed');
$schedule = mysqli_fetch_assoc($schedule_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Schedule</title>

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php @include 'header.php'; ?>

<section class="form-container">
    <form action="" method="post">
        <h3>Update Schedule</h3>
        <input type="datetime-local" name="drop_off_time" value="<?php echo $schedule['drop_off_time']; ?>" placeholder="Drop-off Time" required class="box">

        <select name="drop_off_location" class="box" required>
            <option value="" disabled>Select a Province</option>
            <option value="Western Province" <?php if ($schedule['drop_off_location'] == 'Western Province') echo 'selected'; ?>>Western Province</option>
            <option value="Central Province" <?php if ($schedule['drop_off_location'] == 'Central Province') echo 'selected'; ?>>Central Province</option>
            <option value="Southern Province" <?php if ($schedule['drop_off_location'] == 'Southern Province') echo 'selected'; ?>>Southern Province</option>
            <option value="Northern Province" <?php if ($schedule['drop_off_location'] == 'Northern Province') echo 'selected'; ?>>Northern Province</option>
            <option value="Eastern Province" <?php if ($schedule['drop_off_location'] == 'Eastern Province') echo 'selected'; ?>>Eastern Province</option>
            <option value="North Western Province" <?php if ($schedule['drop_off_location'] == 'North Western Province') echo 'selected'; ?>>North Western Province</option>
            <option value="North Central Province" <?php if ($schedule['drop_off_location'] == 'North Central Province') echo 'selected'; ?>>North Central Province</option>
            <option value="Uva Province" <?php if ($schedule['drop_off_location'] == 'Uva Province') echo 'selected'; ?>>Uva Province</option>
            <option value="Sabaragamuwa Province" <?php if ($schedule['drop_off_location'] == 'Sabaragamuwa Province') echo 'selected'; ?>>Sabaragamuwa Province</option>
        </select>

        <input type="submit" name="update" value="Update Schedule" class="btn">
    </form>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
