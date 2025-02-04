<?php
// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hopefull_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending registrations
$sql = "SELECT * FROM recipient_account_requests WHERE status = 'Pending'";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    // Approve or Reject registration
    if ($action === 'approve') {
        $update_query = "UPDATE recipient_account_requests SET status = 'Approved' WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        // Send approval email
        mail("recipient@example.com", "Registration Approved", "Your registration has been approved!");

    } elseif ($action === 'reject') {
        $update_query = "UPDATE recipient_account_requests SET status = 'Rejected' WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        // Send rejection email
        mail("recipient@example.com", "Registration Rejected", "Your registration has been rejected.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/moderator.css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Recipient Registration</title>
</head>
<body>
    <div class="container">
        <h1>Approve or Reject Recipient Requests</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recipient Name</th>
                    <th>Registration Details</th>
                    <th>Proof Documents</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['details'] ?></td>
                        <td><?= $row['document_path'] ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="action" value="approve" class="approve">Approve</button>
                                <button type="submit" name="action" value="reject" class="reject">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
