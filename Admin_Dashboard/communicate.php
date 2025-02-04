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
    $recipient_id = $_POST['recipient_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO communication_logs (sender_user_id, recipient_user_id, subject, message) 
            VALUES (1, ?, ?, ?)"; // Replace `1` with the logged-in officer's ID
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $recipient_id, $subject, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error sending message: " . $conn->error;
    }
    $stmt->close();
}

$sql_recipients = "SELECT id, name FROM users";
$result_recipients = $conn->query($sql_recipients);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Communicate with Users</title>
  <link rel="stylesheet" href="css/regional_officer.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <h1>Communicate with Users</h1>
  <form method="POST">
    <label for="recipient">Select User:</label>
    <select name="recipient_id" id="recipient" required>
      <?php while ($row = $result_recipients->fetch_assoc()) { ?>
        <option value="<?php echo $row['id']; ?>">
          <?php echo $row['name']; ?>
        </option>
      <?php } ?>
    </select>

    <label for="subject">Subject:</label>
    <input type="text" name="subject" id="subject" required>

    <label for="message">Message:</label>
    <textarea name="message" id="message" rows="5" required></textarea>

    <button type="submit">Send Message</button>
  </form>
</body>
</html>
