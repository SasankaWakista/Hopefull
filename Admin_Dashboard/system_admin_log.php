<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE name=? AND password_hash=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        if (!isset($_SESSION['role']) || $_SESSION['role'] == 'System Admin'){
                header("Location: system_admin_interface.php");
        }else{
                echo "<!DOCTYPE html>
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
                            margin: 0;
                            background-color: #f8d7da;
                            color: #721c24;
                        }
                        .message-container {
                            text-align: center;
                            border: 1px solid #f5c6cb;
                            background-color: #f8d7da;
                            padding: 20px;
                            border-radius: 5px;
                        }
                        .message-container h1 {
                            margin: 0 0 10px;
                            font-size: 24px;
                        }
                        .message-container p {
                            margin: 0;
                            font-size: 18px;
                        }
                    </style>
                </head>
                <body>
                    <div class='message-container'>
                        <h1>Access Denied</h1>
                        <p>You are not a System Administrator.</p>
                    </div>
                </body>
                </html>";
                exit();
        }
    } else {
        echo "Invalid credentials!";
    }
    $stmt->close();
}

$conn->close();
?>
