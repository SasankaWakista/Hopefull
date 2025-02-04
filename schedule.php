<?php

@include 'config.php';

session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the user_id from the session

// Ensure a donation_id is passed via GET
$donation_id = isset($_GET['donation_id']) ? $_GET['donation_id'] : null;

if (!$donation_id) {
    die('Invalid donation ID!');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $donor_name = isset($_POST['donor_name']) ? mysqli_real_escape_string($conn, $_POST['donor_name']) : null;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $drop_off_location = isset($_POST['drop_off_location']) ? mysqli_real_escape_string($conn, $_POST['drop_off_location']) : null;
    $drop_off_time = isset($_POST['drop_off_time']) ? mysqli_real_escape_string($conn, $_POST['drop_off_time']) : null;
    $drop_off_status = 'Pending'; // Default status

    // Validate input
    if (empty($donor_name) || empty($quantity) || empty($drop_off_location) || empty($drop_off_time)) {
        $message[] = 'Please fill in all required fields.';
    } else {
        // Insert into database with the user_id from the session
        $query = "INSERT INTO `non_monetary_schedules` (donation_id, donor_name, quantity, drop_off_location, drop_off_time, status, user_id) 
                  VALUES ('$donation_id', '$donor_name', '$quantity', '$drop_off_location', '$drop_off_time', '$drop_off_status', '$user_id')";

        if (mysqli_query($conn, $query)) {
            $message[] = 'Schedule successful!';
        } else {
            $message[] = 'Failed to schedule donation: ' . mysqli_error($conn);
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
    <title>Schedule Donation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php @include 'header.php'; ?>

<section class="checkout">

    <form action="" method="POST">
        <h3>Schedule Your Donation</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Your Name :</span>
                <input type="text" name="donor_name" required>
            </div>
            <div class="inputBox">
                <span>Quantity :</span>
                <input type="number" name="quantity" min="1" required>
            </div>
            <div class="inputBox">
                <span>Drop-off Location :</span>
                <select name="drop_off_location" required>
                    <option value="">--Select Province--</option>
                    <option value="Central Province">Central Province</option>
                    <option value="Eastern Province">Eastern Province</option>
                    <option value="Northern Province">Northern Province</option>
                    <option value="Southern Province">Southern Province</option>
                    <option value="Western Province">Western Province</option>
                    <option value="North Western Province">North Western Province</option>
                    <option value="North Central Province">North Central Province</option>
                    <option value="Uva Province">Uva Province</option>
                    <option value="Sabaragamuwa Province">Sabaragamuwa Province</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Drop-off Time :</span>
                <input type="datetime-local" name="drop_off_time" required>
            </div>
        </div>

        <input type="submit" value="Schedule Now" class="btn">
    </form>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
