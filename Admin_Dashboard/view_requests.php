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

// Fetch requests from the database
$sql = "SELECT * FROM recipient WHERE status = 'Pending'";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $update_query = "UPDATE recipient SET status = 'Approved' WHERE id = ?";
    } elseif ($action === 'reject') {
        $update_query = "UPDATE recipient SET status = 'Rejected' WHERE id = ?";
    }

    if (isset($update_query)) {
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('i', $request_id);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Request $action successfully.</p>";
            // Optional: Uncomment the mail() function once email is configured
            // mail("recipient@example.com", "Request $action", "Your request has been $action.");
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
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
    <title>View Requests</title>
</head>
<body>
    <div class="container">
        <h1>View Recipient Registration Requests</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recipient Name</th>
                    <th>Proof Documents</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td>
    <?php if (!empty($row['document_path'])): ?>
        <a href="../Recipient/uploaded_files/<?php echo htmlspecialchars($row['document_path']) ?>" target="_blank">View Document</a>
    <?php else: ?>
        No Document Available
    <?php endif; ?>
</td>

                        <td>
                            <form method="POST">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
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
