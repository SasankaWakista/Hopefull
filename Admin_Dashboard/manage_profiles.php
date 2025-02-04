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

// Fetch profiles based on role
$sql = "SELECT id, name, email, role FROM users WHERE role IN ('Donor', 'Recipient', 'Seller', 'Delivery Officer', 'Authentication Moderator', 'Regional Manager')";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profiles</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/manage_profiles.css">
</head>

<body>
    <div class="container">
        <h1>Manage Profiles</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['role']}</td>
                                <td>
                                    <button onclick=\"updateProfile({$row['id']})\">Update</button>
                                    <button onclick=\"deleteProfile({$row['id']})\">Delete</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No profiles found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<script>
    function updateProfile(id) {
        window.location.href = `update_profile.php?id=${id}`;
    }
    function deleteProfile(id) {
        if (confirm("Are you sure you want to delete this profile?")) {
            window.location.href = `delete_profile.php?id=${id}`;
        }
    }
</script>

<?php
$conn->close();
?>
