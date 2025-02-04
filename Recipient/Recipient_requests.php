<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Recipient_login.php"); 
    exit();
}

if (isset($_POST['add_donation'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $donation_type = mysqli_real_escape_string($conn, $_POST['donation_type']);
    $deadline_date = mysqli_real_escape_string($conn, $_POST['deadline_date']);
    $recipient_id = $_SESSION['user_id'];

    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $proof_document = $_FILES['proof_document']['name'];
    $proof_tmp_name = $_FILES['proof_document']['tmp_name'];
    $proof_folder = 'uploaded_files/' . $proof_document;

    if (empty($category) || empty($description) || empty($deadline_date) || empty($image) || empty($proof_document)) {
        $message[] = 'All fields are required!';
    } else {
        if ($donation_type === 'monetary') {
            $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
        } else {
            $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        }
        $insert_donation = mysqli_query($conn, "INSERT INTO donation_requests (category, description, total_amount, quantity, donation_type, deadline_date, image, proof_document, amount_donated) VALUES ('$category', '$description', '$total_amount', '$quantity', '$donation_type', '$deadline_date', '$image', '$proof_document', 0)") or die('query failed');
        
        if ($insert_donation) {
            move_uploaded_file($image_tmp_name, $image_folder);
            move_uploaded_file($proof_tmp_name, $proof_folder);
            $message[] = 'Donation request added successfully!';
            header("Location: Recipient_requests.php");
        } else {
            $message[] = 'Failed to add donation request!';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Use prepared statement to prevent SQL injection
    $select_delete = mysqli_prepare($conn, "SELECT * FROM donation_requests WHERE id = ?");
    mysqli_stmt_bind_param($select_delete, "i", $delete_id);
    mysqli_stmt_execute($select_delete);
    $result = mysqli_stmt_get_result($select_delete);

    if ($fetch_delete = mysqli_fetch_assoc($result)) {
        $image_path = 'uploaded_img/' . $fetch_delete['image'];
        $proof_path = 'uploaded_files/' . $fetch_delete['proof_document'];

        // Check if the image and proof document exist before unlinking
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        if (file_exists($proof_path)) {
            unlink($proof_path);
        }

        // Delete the donation request from the database
        $delete_query = mysqli_prepare($conn, "DELETE FROM donation_requests WHERE id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $delete_id);
        if (mysqli_stmt_execute($delete_query)) {
            $message[] = 'Donation request deleted successfully!';
        } else {
            $message[] = 'Failed to delete donation request from database!';
        }
    } else {
        $message[] = 'Donation request not found!';
    }

    header('location:Recipient_requests.php');
    exit; 
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

        .add-donation-btn {
            display: block;
            margin: 20px auto; /* Center the button */
            padding: 10px 20px;
            background-color: #901357;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
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
                <span>Email : <?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                <a href="Recipient_Dashboard.php">My Dashboard</a> 
                <a href="Recipient_login.php">Logout</a>
            </div>
        </div>
    </nav>
</header>

<button class="add-donation-btn btn" onclick="toggleDonationForm()">Add New Donation Request</button>

<section class="add-donations" id="donationForm">
    <form action="Recipient_requests.php" method="POST" enctype="multipart/form-data" onsubmit="return validateDeadlineDate() && checkValues();">
        <h3>Add New Donation Request</h3>
        
        <label>Category:</label><br>
        <input type="radio" name="category" value="healthcare" required> Healthcare
        <input type="radio" name="category" value="education"> Education
        <input type="radio" name="category" value="volunteer"> Volunteer
        <input type="radio" name="category" value="community"> Community
        <input type="radio" name="category" value="sports"> Sports
        <input type="radio" name="category" value="make_a_wish"> Make A Wish<br><br>

        <label>Add description:</label><br>
        <textarea name="description" class="box" required placeholder="Enter donation description" cols="30" rows="5"></textarea>
        
        <label>Type:</label><br>
        <input type="radio" name="donation_type" value="monetary" onclick="toggleAmountFields()" required> Monetary
        <input type="radio" name="donation_type" value="non_monetary" onclick="toggleAmountFields()"> Non-Monetary<br><br>

        <div id="amountField" style="display: none;">
            <input type="number" min="0" class="box" placeholder="Enter donation amount" name="total_amount">
        </div>

        <div id="quantityField" style="display: none;">
            <input type="number" name="quantity" placeholder="Enter quantity" min="1" class="box">
        </div>

        <label>Deadline date:</label><br>
        <input type="date" class="box" required name="deadline_date">
        <label>Upload donation image:</label><br>
        <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image" placeholder="Upload donation image">
        <label>Upload proof document:</label><br>
        <input type="file" accept=".pdf,.doc,.docx" required class="box" name="proof_document" placeholder="Upload proof document">
        <input type="submit" value="Add Donation Request" name="add_donation" class="btn">
    </form>
</section>
<section class="show-donations">
    <div class="box-container">
        <?php
        $select_donations = mysqli_query($conn, "SELECT * FROM donation_requests") or die('query failed');
        if (mysqli_num_rows($select_donations) > 0) {
            while ($fetch_donations = mysqli_fetch_assoc($select_donations)) {
        ?>
        <div class="box">
                <?php if ($fetch_donations['donation_type'] === 'Monetary') { ?>
                    <div class="goal">Goal: Rs. <?php echo $fetch_donations['total_amount']; ?></div>
                    <div class="raised">Raised: Rs. <?php echo $fetch_donations['amount_donated']; ?></div>
                <?php } else { ?>
                    <div class="goal">Quantity: <?php echo $fetch_donations['quantity']; ?></div>
                    <div class="raised">Recieved: <?php echo $fetch_donations['amount_donated']; ?></div>
                <?php } ?>
            <img class="image" src="uploaded_img/<?php echo $fetch_donations['image']; ?>" alt="">
            <div class="description"><?php echo $fetch_donations['description']; ?></div>
            <div class="deadline">Deadline: <?php echo $fetch_donations['deadline_date']; ?></div>
            <a href="uploaded_files/<?php echo $fetch_donations['proof_document']; ?>" target="_blank" class="btn">View Proof</a>
            <a href="donation_update.php?update=<?php echo $fetch_donations['id']; ?>" class="option-btn">Update</a>
            <a href="javascript:void(0);" class="delete-btn" onclick="confirmDelete(<?php echo $fetch_donations['id']; ?>);">Delete</a>
        </div>
        <?php
            }
        } else {
            echo '<p class="empty">No donation requests added yet!</p>';
        }
        ?>
    </div>


    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>Are you sure you want to delete this donation request? This action cannot be undone.</p>
            <button id="confirmDeleteBtn" class="btn">Delete</button>
            <button onclick="closeModal()" class="btn">Cancel</button>
        </div>
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

<script>
let currentDeleteId = null; // Store the ID of the donation to be deleted

function confirmDelete(id) {
    currentDeleteId = id; // Store the ID for later use
    document.getElementById("confirmModal").style.display = "block"; // Show the modal
}

function closeModal() {
    document.getElementById("confirmModal").style.display = "none"; // Hide the modal
}

// Confirm deletion when the button is clicked
document.getElementById("confirmDeleteBtn").onclick = function() {
    if (currentDeleteId) {
        window.location.href = "Recipient_requests.php?delete=" + currentDeleteId; // Redirect to delete
    }
};

function toggleAmountFields() {
    const donationType = document.querySelector('input[name="donation_type"]:checked').value;
    const amountField = document.getElementById('amountField');
    const quantityField = document.getElementById('quantityField');

    if (donationType === 'monetary') {
 amountField.style.display = 'block';
        quantityField.style.display = 'none';
    } else {
        amountField.style.display = 'none';
        quantityField.style.display = 'block';
    }
}

function checkValues() {
    const donationType = document.querySelector('input[name="donation_type"]:checked').value;
    const totalAmount = document.querySelector('input[name="amountField"]');
    const quantity = document.querySelector('input[name="quantityField"]');

    if (donationType === 'monetary' && totalAmount.value <= 0) {
        alert('Please enter a valid donation amount!');
        totalAmount.focus();
        return false;
    }

    if (donationType === 'non_monetary' && quantity.value <= 0) {
        alert('Please enter a valid quantity!');
        quantity.focus();
        return false;
    }
}

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

function toggleDonationForm() {
    const donationForm = document.getElementById('donationForm');
    donationForm.style.display = donationForm.style.display === 'none' || donationForm.style.display === '' ? 'block' : 'none';
}

</script>

</body>
</html>