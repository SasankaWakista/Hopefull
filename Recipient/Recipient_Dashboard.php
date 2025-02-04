<?php
@include 'config.php'; // Include database connection
session_start();


/*if (!isset($_SESSION['user_id'])) {
    header("Location: Recipient_login.php"); // Redirect to login page
    exit();
}*/

// Fetch user's donations
$user_id = $_SESSION['user_id'];
$donations_query = mysqli_query($conn, "SELECT * FROM donation_requests WHERE recipient_id = '$user_id'") or die('Query failed');
$total_donated = 0; // Initialize total donated amount
$donation_data = []; // Array to hold donation data

while ($row = mysqli_fetch_assoc($donations_query)) {
    $donation_data[] = $row; // Store each donation request
    $total_donated += $row['amount_donated']; // Sum the total donated amount
}

// Fetch today's donations
$today_donations_query = mysqli_query($conn, "SELECT SUM(amount_donated) AS today_total FROM donation_requests WHERE recipient_id = '$user_id' AND DATE(deadline_date) = CURDATE()") or die('Query failed');
$today_donated = mysqli_fetch_assoc($today_donations_query)['today_total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipient Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="stylePages/dashboard_style.css">
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
    <div class="sidebar">
        <div class="logo">
            <img src="images/logo.png" alt="logo">
        </div>
        <ul class="menu">
            <li class="active"><a href="#">
                <i class="fas fa-tachometer-alt"></i>
                <span class="nav-item">Dashboard</span>
            </a></li>
            <li><a href="profile.php">
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
                <span>Recipient</span>
                <h2>Dashboard</h2>
            </div>
            <div class="user-icon">
                <i class="fas fa-user" style="font-size: 30px;"></i>
                <div class="user-dropdown">
                    <span>Email : <?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                    <a href="Recipient_login.php">Logout</a>
                </div>
            </div>
        </div>

        <div class="card-container">
            <h1 class="main-title">Today's data</h1>
            <div class="card-wrapper">
                <div class="payment-card light-purple">
                    <div class="card-header">
                        <div class="amount">
                            <span class="title">Recived donation amount</span>
                            <span class="amount-value">$<?php echo number_format($today_donated, 2); ?></span>
                        </div>
                        <i class="fas fa-dollar-sign icon"></i>
                    </div>
                </div>
                <div class="payment-card light-pink">
                    <div class="card-header">
                        <div class="amount">
                            <span class="title">Total recieved donations</span>
                            <span class="amount-value">$<?php echo number_format($total_donated, 2); ?></span>
                        </div>
                        <i class="fas fa-list icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabular-wrapper">
            <h3 class="main-title">Donation data</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Donor</th>
                            <th>Donation method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Donation message</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php if (empty($donation_data)): ?>
                             <tr>
                            <td colspan="6" class="empty">No donations available.</td>
                            </tr>
                        <?php else: ?>
                         <?php foreach ($donation_data as $donation): ?>
                                <tr>
                            <td><?php echo date('d/m/Y', strtotime($donation['deadline_date'])); ?></td>
                            <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                            <td><?php echo htmlspecialchars($donation['donation_method']); ?></td>
                            <td>$<?php echo number_format($donation['amount_donated'], 2); ?></td>
                            <td><?php echo htmlspecialchars($donation['status']); ?></td>
                            <td><?php echo htmlspecialchars($donation['description']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Total</td>
                            <td>$<?php echo number_format($total_donated, 2); ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</body>
</html>