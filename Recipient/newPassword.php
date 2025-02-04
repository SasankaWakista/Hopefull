<?php
@include 'config.php';
session_start();

if (isset($_POST['reset_password'])) {
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
    $new_password = mysqli_real_escape_string($conn, $filter_password);

    $check_email = mysqli_query($conn, "SELECT * FROM recipient WHERE email = '$email' AND approved = 1") or die('query failed');

    if (mysqli_num_rows($check_email) > 0) {
        $update_password = mysqli_query($conn, "UPDATE recipient SET password = '$new_password' WHERE email = '$email'") or die('query failed');

        if ($update_password) {
            $message[] = 'Password reset successfully. You can now log in with your new password.';
        } else {
            $message[] = 'Failed to reset password. Please try again.';
        }
    } else {
        $message[] = 'No approved user found with that email.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="stylePages/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>

        .reset{
            margin-left:5px;
        }

        #resetPassword {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px); 
        }

        .form-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .input-box {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-box span {
            display: block;
            margin-bottom: 10px;
        }

        .input-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-box p{
            margin-left:15px;
        }

        .message {
            margin-top: 10px;
            color: red;
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
                <li onclick="hideSidebar()" style="cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960" width="40">
                        <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                    </svg>
                </li>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <li><a href="#">Market Place</a></li>
                <li><a href="#">Make A Wish</a></li>
                <li><a href="#">Terms and Conditions</a></li>  
                <li><a href="Recipient_login.php" class="btn login">Log in</a></li>
                <li><a href="Recipient_register.php" class="btn register">Register</a></li>         
            </ul>
            <ul class="nav-links">
                <li class="hideOnMobile"><a href="#">Home</a></li>
                <li class="hideOnMobile"><a href="#">About Us</a></li>
                <li class="hideOnMobile"><a href="#">Gallery</a></li>
                <li class="hideOnMobile"><a href="#">Contact Us</a></li>
                <li class="dropdown hideOnMobile">
                    <a href="#" class="dropbtn">More</a>
                    <div class="dropdown-content">
                        <a href="#">Market Place</a>
                        <a href="#">Make A Wish</a>
                        <a href="#">Terms and Conditions</a>
                    </div>
                </li>
            </ul>
            <div class="auth-buttons hideOnMobile">
                <a href="Recipient_login.php" class="btn login">Log in</a>
                <a href="Recipient_register.php" class="btn register">Register</a>
            </div>
            <ul style="list-style-type: none;" class="hideOnLaptop">
                <li class="menu-button" onclick="showSidebar()">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/ 2000/svg" height="40" viewBox="0 -960 960 960" width="40">
                            <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <section id="resetPassword">
        <div class="form-box">
            <span class="Welcome">Reset Password</span>
            <h1>Enter your new password</h1>
            <form action="newPassword.php" method="POST">
                <div class="input-box">
                    <span>Email</span>
                    <input type="email" name="email" placeholder="enter your email" required>
                </div>
                <div class="input-box">
                    <span>New Password</span>
                    <input type="password" name="new_password" placeholder="enter your new password" required>
                </div>
                <button type="submit" class="reset btn" name="reset_password">Reset Password</button>
                <p class="noAccount">Remembered your password? <br><a href="Recipient_login.php">Log in now</a></p>
            </form>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="images/logo.png" alt="Hopefull Logo">
            </div>
            <p>&copy; 2024 Hopefull. All rights reserved.</p>
        </div>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms and Conditions</a>
            <a href="#">Contact us</a>
        </div>
        <div class="social-media">
            <a href="#facebook"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="32px" height="32px">    <path d="M 5 3 C 3.897 3 3 3.897 3 5 L 3 19 C 3 20.103 3.897 21 5 21 L 11.621094 21 L 14.414062 21 L 19 21 C 20.103 21 21 20.103 21 19 L 21 5 C 21 3.897 20.103 3 19 3 L 5 3 z M 5 5 L 19 5 L 19.001953 19 L 14.414062 19 L 14.414062 15.035156 L 16.779297 15.035156 L 17.130859 12.310547 L 14.429688 12.310547 L 14.429688 10.574219 C 14.429687 9.7862188 14.649297 9.2539062 15.779297 9.2539062 L 17.207031 9.2539062 L 17.207031 6.8222656 C 16.512031 6.7512656 15.814234 6.71675 15.115234 6.71875 C 13.041234 6.71875 11.621094 7.9845938 11.621094 10.308594 L 11.621094 12.314453 L 9.2773438 12.314453 L 9.2773438 15.039062 L 11.621094 15.039062 L 11.621094 19 L 5 19 L 5 5 z"/></svg></a>
            <a href="#instagram"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="32px" height="32px">    <path d="M 8 3 C 5.243 3 3 5.243 3 8 L 3 16 C 3 18.757 5.243 21 8 21 L 16 21 C 18.757 21 21 18.757 21 16 L 21 8 C 21 5.243 18.757 3 16 3 L 8 3 z M 8 5 L 16 5 C 17.654 5 19 6.346 19 8 L 19 16 C 19 17.654 17.654 19 16 19 L 8 19 C 6.346 19 5 17.654 5 16 L 5 8 C 5 6.346 6.346 5 8 5 z M 17 6 A 1 1 0 0 0 16 7 A 1 1 0 0 0 17 8 A 1 1 0 0 0 18 7 A 1 1 0 0 0 17 6 z M 12 7 C 9.243 7 7 9.243 7 12 C 7 14.757 9.243 17 12 17 C 14.757 17 17 14.757 17 12 C 17 9.243 14.757 7 12 7 z M 12 9 C 13.654 9 15 10.346 15 12 C 15 13.654 13.654 15 12 15 C 10.346 15 9 13.654 9 12 C 9 10.346 10.346 9 12 9 z"/></svg></a>
            <a href="#twitter"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="32px" height="32px"><path d="M 2.3671875 3 L 9.4628906 13.140625 L 2.7402344 21 L 5.3808594 21 L 10.644531 14.830078 L 14.960938 21 L 21.871094 21 L 14.449219 10.375 L 20.740234 3 L 18.140625 3 L 13.271484 8.6875 L 9.2988281 3 L 2.3671875 3 z M 6.2070312 5 L 8.2558594 5 L 18.033203 19 L 16.001953 19 L 6.2070312 5 z"/></svg></a>
            <a href="#linkedIn"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="32px" height="32px">    <path d="M 5 3 C 3.895 3 3 3.895 3 5 L 3 19 C 3 20.105 3.895 21 5 21 L 19 21 C 20.105 21 21 20.105 21 19 L 21 5 C 21 3.895 20.105 3 19 3 L 5 3 z M 5 5 L 19 5 L 19 19 L 5 19 L 5 5 z M 7.7792969 6.3164062 C 6.9222969 6.3164062 6.4082031 6.8315781 6.4082031 7.5175781 C 6.4082031 8.2035781 6.9223594 8.7167969 7.6933594 8.7167969 C 8.5503594 8.7167969 9.0644531 8.2035781 9.0644531 7.5175781 C 9.0644531 6.8315781 8.5502969 6.3164062 7.7792969 6.3164062 z M 6.4765625 10 L 6.4765625 17 L 9 17 L 9 10 L 6.4765625 10 z M 11.082031 10 L 11.082031 17 L 13.605469 17 L 13.605469 13.173828 C 13.605469 12.034828 14.418109 11.871094 14.662109 11.871094 C 14.906109 11.871094 15.558594 12.115828 15.558594 13.173828 L 15.558594 17 L 18 17 L 18 13.173828 C 18 10.976828 17.023734 10 15.802734 10 C 14.581734 10 13.930469 10.406562 13.605469 10.976562 L 13.605469 10 L 11.082031 10 z"/></svg></a>
        </div>
    </footer>

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

