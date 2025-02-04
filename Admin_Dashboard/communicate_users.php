<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hopefull_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipient = $_POST['recipient'];
    $message = $_POST['message'];
    $sql = "INSERT INTO admin_messages (sender_id, recipient_id, message) VALUES ('1', '$recipient', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT id, name FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communicate with Users</title>
    <link rel="stylesheet" href="css/communicate_users.css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Communicate with Users</h1>
        <form method="POST">
            <label for="recipient">Select Recipient:</label>
            <select name="recipient" id="recipient" required>
                <option value="">-- Select User --</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                }
                ?>
            </select>
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="5" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
