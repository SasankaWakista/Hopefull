<?php
@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

// Update stock
if (isset($_POST['update_stock'])) {
    $update_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $new_stock = mysqli_real_escape_string($conn, $_POST['new_stock']);
    
    // Fetch current stock
    $select_current_stock = mysqli_query($conn, "SELECT stock FROM `products` WHERE id = '$update_id'") or die('query failed');
    $current_stock = mysqli_fetch_assoc($select_current_stock)['stock'];
    
    // Calculate new stock by adding the new stock to the current stock
    $updated_stock = $current_stock + $new_stock;

    // Update stock in the database
    mysqli_query($conn, "UPDATE `products` SET stock = '$updated_stock' WHERE id = '$update_id'") or die('query failed');
    $message[] = 'Stock updated successfully!';
}

// Delete a product
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
    unlink('uploaded_img/' . $fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_inventory.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inventory</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- Custom Admin CSS -->
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="inventory">
   <h3 class="title">Inventory</h3>
   <table class="inventory-table">
      <thead>
         <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Details</th>
            <th>Image</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($row = mysqli_fetch_assoc($select_products)) {
               echo "<tr>
                     <td>{$row['id']}</td>
                     <td>{$row['name']}</td>
                     <td>{$row['price']}</td>
                     <td>{$row['stock']}</td>
                     <td>{$row['details']}</td>
                     <td><img src='uploaded_img/{$row['image']}' height='50' alt=''></td>
                     <td>
                        <form action='' method='POST' style='display: inline-block;'>
                           <input type='hidden' name='product_id' value='{$row['id']}'>
                           <input type='number' min='0' name='new_stock' placeholder='Add Stock' class='box' required>
                           <input type='submit' name='update_stock' value='Update' class='btn'>
                        </form>
                        <a href='admin_inventory.php?delete={$row['id']}' class='delete-btn'>Delete</a>
                     </td>
                  </tr>";
            }
         } else {
            echo "<tr><td colspan='7' class='empty'>No products found</td></tr>";
         }
         ?>
      </tbody>
   </table>
</section>

<script src="js/admin_script.js"></script>

</body>
</html>
