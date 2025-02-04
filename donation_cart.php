<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM donation_cart WHERE id = '$delete_id'") or die('query failed');
    header('location:donation_cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM donation_cart WHERE user_id = '$user_id'") or die('query failed');
    header('location:donation_cart.php');
}

// Process donations
if (isset($_POST['donate_all'])) {
    $cart_items = mysqli_query($conn, "SELECT * FROM donation_cart WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_items) > 0) {
        while ($item = mysqli_fetch_assoc($cart_items)) {
            $donation_id = $item['donation_id'];
            $donation_amount = $item['donation_amount'];

            // Update donation request
            $update_request = mysqli_query($conn, "UPDATE donation_requests SET amount_donated = amount_donated + '$donation_amount' WHERE id = '$donation_id'") or die('query failed');

            // Remove from cart
            mysqli_query($conn, "DELETE FROM donation_cart WHERE id = '{$item['id']}'") or die('query failed');
        }
        $message[] = 'Donations processed successfully!';
    } else {
        $message[] = 'Your cart is empty!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Donation Cart</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS File -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .donation-cart .box-container {
          max-width: 1200px;
          margin: 0 auto;
          display: grid;
          grid-template-columns: repeat(auto-fit, 33rem);
          gap: 1.5rem;
          align-items: flex-start;
          justify-content: center;
      }

      .donation-cart .box-container .box {
          padding: 2rem;
          text-align: center;
          background-color: var(--white);
          border: var(--border);
          box-shadow: var(--box-shadow);
          border-radius: 0.5rem;
          position: relative;
      }

      .donation-cart .box-container .box .image {
          height: 35rem;
          width: 100%;
          object-fit: cover;
      }

      .donation-cart .box-container .box .fa-eye,
      .donation-cart .box-container .box .fa-times {
          position: absolute;
          top: 1rem;
          height: 4.5rem;
          width: 4.5rem;
          line-height: 4.3rem;
          font-size: 2rem;
          border-radius: 0.5rem;
      }

      .donation-cart .box-container .box .fa-eye {
          right: 1rem;
          border: var(--border);
          background-color: var(--white);
          color: var(--black);
      }

      .donation-cart .box-container .box .fa-eye:hover {
          background-color: var(--black);
          color: var(--white);
      }

      .donation-cart .box-container .box .fa-times {
          background-color: var(--red);
          color: var(--white);
      }

      .donation-cart .box-container .box .fa-times:hover {
          background-color: var(--black);
      }

      .donation-cart .box-container .box .name {
          font-size: 2rem;
          color: var(--black);
          margin: 1rem 0;
      }

      .donation-cart .box-container .box .price {
          font-size: 1.8rem;
          color: var(--light-color);
          margin: 1rem 0;
      }

      .donation-cart .cart-actions {
          text-align: center;
          margin-top: 2rem;
      }

      .donation-cart .cart-actions .delete-btn {
          padding: 1rem 2rem;
          background-color: var(--red);
          color: var(--white);
          border: none;
          cursor: pointer;
          border-radius: 0.5rem;
      }

      .donation-cart .cart-actions .btn {
          padding: 1rem 2rem;
          background-color: var(--blue);
          color: var(--white);
          border: none;
          cursor: pointer;
          border-radius: 0.5rem;
      }

      .donation-cart .empty {
          font-size: 1.8rem;
          color: var(--light-color);
          text-align: center;
      }
   </style>
</head>
<body>

<?php @include 'header.php'; ?>

<section class="donation-cart">

   <h1 class="title">Your Donation Cart</h1>

   <div class="box-container">
      <?php
         $cart_items = mysqli_query($conn, "SELECT donation_cart.*, donation_requests.description, donation_requests.image FROM donation_cart JOIN donation_requests ON donation_cart.donation_id = donation_requests.id WHERE donation_cart.user_id = '$user_id'") or die('query failed');
         if (mysqli_num_rows($cart_items) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($cart_items)) {
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="Donation Image" class="image">
         <div class="name"><?php echo $fetch_cart['description']; ?></div>
         <div class="price">Amount: Rs.<?php echo $fetch_cart['donation_amount']; ?></div>
         <a href="donation_cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="delete-btn">Remove</a>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">Your donation cart is empty!</p>';
      }
      ?>

   </div>

   <div class="cart-actions">
      <a href="donation_cart.php?delete_all" class="delete-btn">Clear Cart</a>
      <form method="POST">
         <input type="submit" name="donate_all" value="Donate All" class="btn">
      </form>
   </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
