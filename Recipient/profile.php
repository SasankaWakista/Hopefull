<?php
@include 'config.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Recipient_login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: Recipient_login.php"); // Redirect to login page
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn, "SELECT * FROM recipient WHERE id = '$user_id'") or die('Query failed');
$user_data = mysqli_fetch_assoc($user_query);

// Fetch additional profile data
$profile_query = mysqli_query($conn, "SELECT * FROM recipient_profile WHERE recipient_id = '$user_id'") or die('Query failed');
$profile_data = mysqli_fetch_assoc($profile_query);

// Initialize profile data if it does not exist
if (!$profile_data) {
    $profile_data = [
        'date_of_birth' => '',
        'gender' => '',
        'address' => '',
        'contact_number' => '' // Initialize contact_number
    ];
} else {
    // Ensure contact_number is set, in case it's not present in the fetched data
    if (!isset($profile_data['contact_number'])) {
        $profile_data['contact_number'] = ''; // Default value if not set
    }
}

// Handle form submissions for updating user information
if (isset($_POST['update_info'])) {
    $new_name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_dob = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $new_gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $new_address = mysqli_real_escape_string($conn, $_POST['address']);
    $new_contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']); // Get contact_number

    // Update user information
    $update_user_query = mysqli_query($conn, "UPDATE recipient SET name = '$new_name', email = '$new_email' WHERE id = '$user_id'") or die('Query failed');
    
    // Update profile information
    if ($profile_data && !empty($profile_data['date_of_birth'])) {
        // If profile exists, update it
        $update_profile_query = mysqli_query($conn, "UPDATE recipient_profile SET date_of_birth = '$new_dob', gender = '$new_gender', address = '$new_address', contact_number = '$new_contact_number' WHERE recipient_id = '$user_id'") or die('Query failed');
    } else {
        // If profile does not exist, insert it
        $insert_profile_query = mysqli_query($conn, "INSERT INTO recipient_profile (recipient_id, date_of_birth, gender, address, contact_number) VALUES ('$user_id', '$new_dob', '$new_gender', '$new_address', '$new_contact_number')") or die('Query failed');
    }

    if ($update_user_query || $update_profile_query || $insert_profile_query) {
        $message[] = 'Profile updated successfully.';
        $_SESSION['user_name'] = $new_name; // Update session name
        $_SESSION['user_email'] = $new_email; // Update session email
    } else {
        $message[] = 'Failed to update profile.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="stylePages/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>

        body{
            display:flex;
        }

        .menu a span{
        overflow: hidden;
        }

        #profile {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
        }

        .form-box h2{
            margin-bottom: 0px;
        }

        .form-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 550px;
            text-align: center;
            height: 610px;
        }

        .input-box {
            margin-bottom: 15px;
            text-align: left;
            margin-left:10px;
        }

        .message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .message i {
            cursor: pointer;
        }

        .form-box i{
            margin-left:-70px;
            margin-right:15px;
        }

        .form-box p{
            font-weight:bold;
            margin-bottom:8px;
        }

        .submit{
            font-size:15px;
            margin-left:10px;
        }
        
        .header-wrapper h2{
            margin-top:5px;
        }

        select {
            width: 95%;
            padding: 10px 10px;
            border: 1px solid #901357;
            border-radius: 30px;
            background-color:#bbbabb;
        }

        
    </style>
</head>
<body>
    

    <div class="sidebar1">
        <div class="logo">
            <img src="images/logo.png" alt="logo">
        </div>
        <ul class="menu">
            <li><a href="Recipient_Dashboard.php">
                <i class="fas fa-tachometer-alt"></i>
                <span class="nav-item">Dashboard</span>
            </a></li>
            <li class="active"><a href="profile.php">
                <i class="fas fa-user"></i>
                <span class="nav-item">Profile</span>
            </a></li>
            <li><a href="Recipient_requests.php">
                <i class="fas fa-donate"></i>
                <span class="nav-item">Request donation</span>
            </a></li>
            <li><a href="send_message.php">
                <i class="fas fa-envelope"></i>
                <span class="nav-item">Messages</span>
            </a></li>
            <li class="logout"><a href="Recipient_login.php">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Logout</span>
            </a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header-wrapper">
            <div class ="header-title">
                <span class="reci">Recipient</span>
                <h2>Profile</h2>
            </div>
            <div class="user-icon">
                <i class="fas fa-user" style="font-size: 30px;"></i>
                <div class="user-dropdown">
                    <span>Email : <?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                    <a href="Recipient_login.php">Logout</a>
                </div>
            </div>
        </div>
        <section id="profile">
            <div class="form-box">
                <h2>User Profile</h2>
                <form action="profile.php" method="POST">
                    <div class="input-box">
                        <span>Name</span>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
                    </div>
                    <div class="input-box">
                        <span>Email</span>
                        <input type=" email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                    </div>
                    <div class="input-box">
                        <span>Date of Birth</span>
                        <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($profile_data['date_of_birth']); ?>" required>
                    </div>
                    <div class="input-box">
                        <span>Gender</span>
                        <select name="gender" required>
                            <option value="Male" <?php echo ($profile_data['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($profile_data['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($profile_data['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span>Contact Number</span>
                        <input type="text" name="contact_number" value="<?php echo htmlspecialchars($profile_data['contact_number']); ?>" required>
                    </div>
                    <div class="input-box">
                        <span>Address</span>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($profile_data['address']); ?>" required>
                    </div>
                    <button type="submit" class="submit btn" name="update_info">Update Information</button>
                    <a href="newPassword.php" class="btn">Change Password</a>
                </form>
            </div>
        </section>
    </div>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message">
                <span>' . $msg . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
        }
    }
    ?>
</body>
</html>