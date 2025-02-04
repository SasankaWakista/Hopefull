<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hopefull_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query to fetch user
    $sql = "SELECT * FROM admin_users WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Validate plaintext password
        if ($pass === $row['password_hash']) { // Directly compare passwords
            // Set session variables
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // Redirect to the admin page
            if ($row['role'] === 'Market Manager') {
                header("Location: ../hopefullmarketplace/admin_dashboard.php");
                exit();
            } else {
                // Show Access Denied message
                echo "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Access Denied</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            background-color: #f8d7da;
                            color: #721c24;
                        }
                        .message-container {
                            text-align: center;
                            padding: 20px;
                            background: #f8d7da;
                            border: 1px solid #f5c6cb;
                            border-radius: 5px;
                        }
                        .message-container h1 {
                            margin-bottom: 10px;
                            font-size: 24px;
                        }
                    </style>
                </head>
                <body>
                    <div class='message-container'>
                        <h1>Access Denied</h1>
                        <p>You are not a Market Manager.</p>
                    </div>
                </body>
                </html>";
                exit();
            }
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "Invalid credentials!";
    }
    $stmt->close();
}

// Close connection
$conn->close();
?>
