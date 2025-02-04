<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Send email to recipient
    mail($email, "Message from Moderator", $message);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/moderator.css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Communicate with Recipients</title>
</head>
<body>
    <div class="container">
        <h1>Communicate with Recipients</h1>
        <form method="POST">
            <label for="email">Recipient Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="6" required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
