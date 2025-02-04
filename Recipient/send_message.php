<?php
@include 'config.php'; 
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Recipient_login.php"); 
    exit();
}

// Handle form submission
// Handle form submission
if (isset($_POST['send_message'])) {
    $donor_user_id = mysqli_real_escape_string($conn, $_POST['donor_id']); // Ensure using the correct name
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Initialize the variable
    $insert_message = false;

    // Handle file uploads
    $photo = $_FILES['photo']['name'];
    $video = $_FILES['video']['name'];
    $photo_tmp_name = $_FILES['photo']['tmp_name'];
    $video_tmp_name = $_FILES['video']['tmp_name'];

    // Define upload directories
    $photo_folder = 'uploaded_img/' . $photo;
    $video_folder = 'uploaded_videos/' . $video;

    // Validate inputs
    if (empty($donor_user_id) || empty($message) || (empty($photo) && empty($video))) {
        $error_message = 'All fields are required!';
    } else {
        // Ensure donor_user_id is valid
        $donor_check = mysqli_query($conn, "SELECT * FROM donations WHERE donor_user_id = '$donor_user_id'");
        if (mysqli_num_rows($donor_check) == 0) {
            $error_message = 'Invalid donor selected.';
        } else {
            // Proceed with inserting the message into the database
            $insert_message = mysqli_query($conn, "INSERT INTO recipient_donor_messages (recipient_id, donor_user_id, message, photo, video) VALUES ('{$_SESSION['user_id']}', '$donor_user_id', '$message', '$photo', '$video')") or die('Query failed');
        }
    }

    // Check if the insert was successful
    if ($insert_message) {
        // Move uploaded files
        if (!empty($photo)) {
            move_uploaded_file($photo_tmp_name, $photo_folder);
        }
        if (!empty($video)) {
            move_uploaded_file($video_tmp_name, $video_folder);
        }
        $success_message = 'Message sent successfully!';
    } else {
        $error_message = 'Failed to send message!';
    }
}

        // Fetch donors from the database (for the dropdown)
$donors_query = mysqli_query($conn, "SELECT d.donor_user_id, u.name FROM donations d JOIN users u ON d.donor_user_id = u.id") or die('Query failed');




    ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message to Donor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="stylePages/recipient_style.css">
    <style>
        
        .user-icon i {
            color: black;
        }

        .user-icon i:hover {
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
            border-radius: 15px;
        }

        .user-dropdown span {
            display: block;
            color:#901357;
        }
        
        .user-icon:hover .user-dropdown {
            display: block; 
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
    </style>
</head>

<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <img src="images/logo.png" alt="Hopefull Logo">
        </div>
        <ul class="sidebar">
            <li onclick=hideSidebar() style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960" width="40"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a href="#">Market Place</a></li>
            <li><a href="#">Make A Wish</a></li>
            <li><a href="#">Terms and Conditions</a></li>
        </ul>
        <ul class="nav-links">
            <li class="hideOnMobile"><a href="Recipient_Dashboard.php">Back</a></li>
            <li class="hideOnMobile"><a href="Recipient_login.php">Logout</a></li>
        </ul>
        <div class="user-icon">
            <i class="fas fa-user" style="font-size: 30px;"></i>
            <div class="user-dropdown">
                <span>Username : <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <span>Email : <?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                <a href="Recipient_Dashboard.php">My Dashboard</a> 
                <a href="Recipient_login.php">Logout</a>
            </div>
        </div>
    </nav>
</header>
    <div class="container">
        <h2>Send Message to Donor</h2>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="donor_id">Select Donor:</label>
            <select name="donor_id" required class="box">
    <option value="">-- Select Donor --</option>
    <?php while ($donor = mysqli_fetch_assoc($donors_query)): ?>
        <option value="<?php echo $donor['donor_user_id']; ?>"><?php echo htmlspecialchars($donor['name']); ?></option>
    <?php endwhile; ?>
</select>

            <label for="message">Message:</label>
            <textarea name="message" rows="4" class="box" required placeholder="Type your message here..."></textarea>

            <label for="photo">Upload Photo:</label>
            <input type="file" name="photo" accept="image/*" class="box">

            <label for="video">Upload Video:</label>
            <input type="file" name="video" accept="video/*" class="box">

            <input type="submit" name="send_message" value="Send Message" class="btn">
        </form>
    </div>
</body>
</html>