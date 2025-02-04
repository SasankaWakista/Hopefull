<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

// Add a new product
if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already exists!';
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO `products`(name, details, price, stock, image) VALUES('$name', '$details', '$price', '$stock', '$image')") or die('query failed');

        if ($insert_product) {
            if ($image_size > 2000000000000000000) {
                $message[] = 'Image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Product added successfully!';
            }
        }
    }
}

// Delete a product
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
    unlink('uploaded_img/' . $fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    header('location:addproduct.php');
}

// Update stock
if (isset($_POST['update_stock'])) {
    $update_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $new_stock = mysqli_real_escape_string($conn, $_POST['new_stock']);
    mysqli_query($conn, "UPDATE `products` SET stock = '$new_stock' WHERE id = '$update_id'") or die('query failed');
    $message[] = 'Stock updated successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add New Product</h3>
      <input type="text" class="box" required placeholder="Enter product name" name="name">
      <input type="number" min="0" class="box" required placeholder="Enter product price" name="price">
      <textarea name="details" class="box" required placeholder="Enter product details" cols="30" rows="10"></textarea>
      <input type="number" min="0" class="box" required placeholder="Enter stock quantity" name="stock">
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="Add Product" name="add_product" class="btn">
   </form>

</section>



<script src="js/admin_script.js"></script>

</body>
</html>
