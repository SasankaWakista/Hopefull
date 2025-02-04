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


// Handle AJAX request to mark an issue as resolved
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['solve_report_id'])) {
    $report_id = $_POST['solve_report_id'];

    // Update the report status to 'Resolved'
    $update_sql = "UPDATE issue_reports SET status = 'resolved' WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    exit; // End script execution for AJAX response
}

// Fetch issue reports from the database
$sql = "SELECT ir.id, ir.report_text, ir.status, u.name AS username 
        FROM issue_reports ir 
        JOIN users u ON ir.user_id = u.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handle Issue Reports</title>
    <link rel="stylesheet" href="css/regional_officer.css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container">
        <h1>Messages Received</h1>
        <table>
            <thead>
                <tr>
                    <th>Message ID</th>
                    <th>Username</th>
                    <th>Message Text</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display issue reports
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr id='row-" . $row["id"] . "'>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["report_text"]) . "</td>";
                        echo "<td id='status-" . $row["id"] . "'>" . ucfirst($row["status"]) . "</td>";
                        echo "<td>";

                        // Message button (redirect to a messaging page or functionality)
                        echo "<button onclick=\"window.location.href='message_user.php?user_id=" . $row["id"] . "'\">Message</button> ";

                        // Solved button (visible only if status is pending)
                        if ($row["status"] == "pending") {
                            echo "<button class='solve-button' data-id='" . $row["id"] . "'>Solved</button>";
                        }

                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No messages found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $(".solve-button").click(function() {
                var reportId = $(this).data("id");

                // Send AJAX request to mark the report as solved
                $.post("handle_issue_reports.php", { solve_report_id: reportId }, function(response) {
                    if (response === "success") {
                        // Update the status in the table
                        $("#status-" + reportId).text("Resolved");

                        // Remove the "Solved" button
                        $("#row-" + reportId + " .solve-button").remove();
                    } else {
                        alert("Failed to update status. Please try again.");
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
