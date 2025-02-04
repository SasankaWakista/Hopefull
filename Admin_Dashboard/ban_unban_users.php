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

if (isset($_POST['action']) && isset($_POST['id'])) {
    $id = $_POST['id'];

  
            if ($_POST['action'] == 'ban') {
                $sql = "UPDATE users SET status='banned' WHERE id='$id'";
            } elseif ($_POST['action'] == 'unban') {
                $sql = "UPDATE users SET status='active' WHERE id='$id'";
            }
            $conn->query($sql);
        }
    


$sql_banned = "SELECT id, name, email FROM users WHERE status='banned'";
$sql_active = "SELECT id, name, email FROM users WHERE status='active'";
$result_banned = $conn->query($sql_banned);
$result_active = $conn->query($sql_active);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ban/Unban User Accounts</title>
    <link rel="stylesheet" href="css/ban_unban_accounts.css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<a href="system_admin_interface.php">
      <button style="margin-bottom: 20px;">Back</button>
    </a>
    <div class="container">
        <h1>Ban/Unban User Accounts</h1>
        
        <h2>Active Accounts</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                  
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_active->num_rows > 0) {
                    while ($row = $result_active->fetch_assoc()) {
                        
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                
                                <td>{$row['email']}</td>
                                <td>
                                    <form method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <input type='hidden' name='action' value='ban'>
                                        <button type='submit'>Ban</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                }
                else {
                    echo "<tr><td colspan='4'>No active accounts</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Banned Accounts</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_banned->num_rows > 0) {
                    while ($row = $result_banned->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>
                                    <form method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <input type='hidden' name='action' value='unban'>
                                        <button type='submit'>Unban</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No banned accounts</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
