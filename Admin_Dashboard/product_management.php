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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_id = 1; // Assume logged-in seller ID is 1 (update this with session user ID)
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_description = $_POST['product_description'];

    // File upload
    $upload_dir = "uploads/products/";
    $product_image = $_FILES['product_image']['name'];
    $product_image_path = $upload_dir . basename($product_image);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $product_image_path);

    // Insert product into database
    $query = "INSERT INTO products (seller_id, name, price, description, image_path) 
              VALUES ('$seller_id', '$product_name', '$product_price', '$product_description', '$product_image_path')";
    if (mysqli_query($conn, $query)) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management</title>
  <link rel="stylesheet" href="css/regional_officer.css">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Product Management</h1>
    <form action="product_management.php" method="POST" enctype="multipart/form-data">
      <label for="product_name">Product Name</label>
      <input type="text" name="product_name" id="product_name" required>

      <label for="product_price">Price</label>
      <input type="number" name="product_price" id="product_price" required>

      <label for="product_description">Description</label>
      <textarea name="product_description" id="product_description" rows="4" required></textarea>

      <label for="product_image">Upload Product Image</label>
      <input type="file" name="product_image" id="product_image" required>

      <button type="submit">Add Product</button>
    </form>
  </div>
</body>
</html>
