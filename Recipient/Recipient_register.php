<?php

@include 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    $filter_cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_STRING);
    $cpassword = mysqli_real_escape_string($conn, $filter_cpassword);

    $upload_dir = 'uploaded_files/'; 

    $select_users = mysqli_query($conn, "SELECT * FROM recipient WHERE email = '$email'") or die(mysqli_error($conn));

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User  already exists';
    } else {
        if ($password != $cpassword) {
            $message[] = 'Confirm password not matched!';
        } else {
            if ($_FILES['document_path']['error'] === UPLOAD_ERR_OK) {
                $document_path = $_FILES['document_path']['name'];
                $temp_name = $_FILES['document_path']['tmp_name'];

                if (move_uploaded_file($temp_name, $upload_dir . $document_path)) {
                    mysqli_query($conn, "INSERT INTO recipient(name, email, password, document_path, status) VALUES ('$name', '$email', '$password', '$document_path', 'Pending')") or die(mysqli_error($conn));
                    $_SESSION['request_status'] = 'pending'; 
                    $message[] = 'Sign up successful. Awaiting admin approval.';
                } else {
                    $message[] = 'Failed to upload document';
                }
            } else {
                $message[] = 'Document upload error';
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
    <title>Recipient Sign Up</title>
    <link rel="stylesheet" href="stylePages/StylesSignUp.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logo.png" alt="Hopefull Logo">
            </div>
            <ul class="sidebar">
                <li onclick=hideSidebar() style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960" width="40"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="#">Market Place</a></li>
                <li><a href="#"><a href="#">Make A Wish</a></li>
                <li><a href="#">Terms and Conditions</a></li>  
                <li><a href="Recipient_login.php" class="btn login">Log in</a></li>
                <li><a href="Recipient_register.php" class="btn register">Register</a></li>         
            </ul>
            <ul class="nav-links">
                <li class="hideOnMobile"><a href="home.php">Home</a></li>
                <li class="hideOnMobile"><a href="about.php">About Us</a></li>
                <li class="hideOnMobile"><a href="#">Gallery</a></li>
                <li class="hideOnMobile"><a href="contact.php">Contact Us</a></li>
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
            <ul style="list-style-type: none;" class = "hideOnLaptop">
                <li class="menu-button" onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960" width="40"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
            </ul>
        </nav>
    </header>

    <section id="signUp">
        <div class="signUp-imageholder">
                <img src="images/support.jpg" alt="Sign Up Image" class="signUp-image hideOnMobile">
            </div>
            <div class="signUp-content">
            <div class="form-box">
            <span class="Register">Recipient Register</span>
            <h1>Create Your Account</h1>
            <form action="Recipient_register.php" method="POST" enctype="multipart/form-data" onsubmit="changeButtonText()">
                <div class="input-box">
                    <span>Full Name</span>
                    <input type="text" name="name" id="name" placeholder="enter your full name" required>
                    </div>
                <div class="input-box">
                    <span>Email</span>
                    <input type="email" name="email" id="email" placeholder="enter your email" required>
                    </div>
                <div class="input-box password-field">
                    <span>Password</span>
                    <input type="password" id="password" name="password" required placeholder="enter password">
                    <span class="eye-icon" onclick="togglePasswordVisibility()"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg></span>
                    </div>
                <div class="input-box password-field">
                    <span>Password</span>
                    <input type="password" id="cpassword" name="cpassword" required title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="re-enter password">
                    <span class="eye-icon" onclick="togglePasswordVisibility()"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg></span>
                </div>
                <div class="input-box">
                    <span>Proof of Requirement</span>
                    <input type="file" id="myFile" name="document_path" required title="Must upload a document as proof that the donation request is authentic.">
                    </div>
                <div class ="terms">
                    <input type="checkbox" id="checkbox" required>
                    <label for = "checkbox">I agree to the <a href="#" style="color:#901357">Terms and Conditions.</a></label>
                </div>
                <button type="submit" class="btn" name="submit" id="submit-button" 
                     <?php if (isset($_SESSION['request_status']) && $_SESSION['request_status'] == 'pending') echo 'disabled'; ?>>
                     <?php echo (isset($_SESSION['request_status']) && $_SESSION['request_status'] == 'pending') ? 'Pending Request' : 'Send Request'; ?>
                </button>
                <p>Already have an account? <a href="Recipient_login.php" style="color:#901357">Login now</a></p> 
            </form>
            </div>
        </div>
    </div>
    </section>


    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const cpasswordInput = document.getElementById("cpassword");
                 if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }

                if (cpasswordInput.type === "password") {
                        cpasswordInput.type = "text";
                } else {
                    cpasswordInput.type = "password";
                }
        }
        function showSidebar(){
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = 'flex';
        }
        function hideSidebar(){
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = 'none';
        }
        function changeButtonText() {
     const submitButton = document.getElementById("submit-button");
        submitButton.textContent = "Pending Request";
        submitButton.disabled = true; 
    }

    </script>

    </body>

    

    <?php
    if(isset($message)){
        foreach($message as $message){
           echo '<div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>';
        }
    }
    ?>
</html>

