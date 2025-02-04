<?php
@include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

   
    $select_users = mysqli_query($conn, "SELECT * FROM recipient WHERE email = '$email' AND status = 'Approved'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);
        
        if ($row['password'] === $password) {
            // Set session variables for the logged-in user
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:Recipient_Dashboard.php');
            exit();
        } else {
            $message[] = 'Incorrect email or password.';
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
    <title>Recipient Sign In</title>
    <link rel="stylesheet" href="stylePages/styles.css"> <!-- Linking the CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
                <li><a href="../index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="#">Market Place</a></li>
                <li><a href="#">Make A Wish</a></li>
                <li><a href="#">Terms and Conditions</a></li>  
                <li><a href="Recipient_login.php" class="btn login">Log in</a></li>
                <li><a href="Recipient_register.php" class="btn register">Register</a></li>         
            </ul>
            <ul class="nav-links">
                <li class="hideOnMobile"><a href="../index.php">Home</a></li>
                <li class="hideOnMobile"><a href="about.php">About Us</a></li>
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

    <section id="signIn">
        <div class="signIn-imageholder">
            <img src="images/support.jpg" alt="Sign In Image" class="signUp-image hideOnMobile">
        </div>
        <div class="signIn-content">
            <div class="form-box">
                <span class="Welcome">Recipient Login</span>
                <h1>Login to Your Account</h1>
                <form action="Recipient_login.php" method="POST">
                    <div class="input-box">
                        <span>Email</span>
                        <input type="email" name="email" id="email" placeholder="enter your email" required>
                    </div>
                    <div class="input-box password-field">
                        <span>Password</span>
                        <input type="password" id="password" name="password" placeholder="enter your password" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="forgot"><a href="newPassword.php">Forgot Password?</a></div>
                    <button type="submit" class="btn" name="submit">Login</button>
                    <p class="noAccount">Don't have an account? <a href="Recipient_register.php">Register now</a></p>
                </form>
            </div>
        </div>
    </section>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
        function showSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = 'flex';
        }
        function hideSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = 'none';
        }
    </script>

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