
<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:Admin_Dashboard/market_manager_log.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar Menu with Dynamic Content</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/dashboard_styles.css">
</head>

<body>
  <nav>
    <div class="sidebar-top">
      <span class="shrink-btn">
        <i class='bx bx-chevron-left'></i>
      </span>
      <img src="images/logo.png" class="logo" alt="">
      <h3 class="hide">Hopefull MarketPlace</h3>
    </div>

    <div class="search">
      <i class='bx bx-search'></i>
      <input type="text" class="hide" placeholder="Quick Search ...">
    </div>

    <div class="sidebar-links">
      <ul>
        <div class="active-tab"></div>
        <li class="tooltip-element" data-tooltip="0">
          <a href="admin_page.php" class="active" data-active="0" target="content-frame">
            <div class="icon">
              <i class='bx bx-tachometer'></i>
              <i class='bx bxs-tachometer'></i>
            </div>
            <span class="link hide">Dashboard</span>
          </a>
        </li>

        <li class="tooltip-element" data-tooltip="1">
          <a href="admin_orders.php" data-active="1" target="content-frame">
            <div class="icon">
              <i class='bx bx-folder'></i>
              <i class='bx bxs-folder'></i>
            </div>
            <span class="link hide">Orders</span>
          </a>
        </li>
        <li class="tooltip-element" data-tooltip="2">
          <a href="admin_contacts.php" data-active="2" target="content-frame">
            <div class="icon">
              <i class='bx bx-message-square-detail'></i>
              <i class='bx bxs-message-square-detail'></i>
            </div>
            <span class="link hide">Messages</span>
          </a>
        </li>
        <li class="tooltip-element" data-tooltip="3">
          <a href="admin_inventory.php" data-active="3" target="content-frame">
            <div class="icon">
              <i class='bx bx-bar-chart-square'></i>
              <i class='bx bxs-bar-chart-square'></i>
            </div>
            <span class="link hide">Inventory</span>
          </a>
        </li>

        <li class="tooltip-element" data-tooltip="4">
          <a href="admin_products.php" data-active="4" target="content-frame">
            <div class="icon">
              <i class='bx bx-plus'></i>
              <i class='bx bx-plus'></i>
            </div>
            <span class="link hide">Add Products</span>
          </a>
        </li>

        <li class="tooltip-element" data-tooltip="5">
          <a href="admin_view_products.php" data-active="5" target="content-frame">
            <div class="icon">
              <i class='bx bx-show'></i>
              <i class='bx bx-show'></i>
            </div>
            <span class="link hide">View Products</span>
          </a>
        </li>
        <div class="tooltip">
          <span class="show">Dashboard</span>
          <span>Orders</span>
          <span>Messages</span>
          <span>Analytics</span>
          <span>Add Products</span>
          <span>View Products</span>
        </div>
      </ul>
    </div>

    <div class="sidebar-footer">
      <a href="#" class="account tooltip-element" data-tooltip="0">
        <i class='bx bx-user'></i>
      </a>
      <div class="admin-user tooltip-element" data-tooltip="1">
        <div class="admin-profile hide">
          
          <div class="admin-info">
            <h3>John Doe</h3>
            <h5>Admin</h5>
          </div>
        </div>
        <a href="logout.php" class="log-out">
          <i class='bx bx-log-out'></i>
        </a>
      </div>
      <div class="tooltip">
        <span class="show">Admin</span>
        <span>Logout</span>
      </div>
    </div>
  </nav>

  <main>
    <iframe id="content-frame" name="content-frame" src="admin_page.php" frameborder="0"></iframe>
  </main>
  <script src="js/dashboard_script.js"></script>
</body>

</html>
