<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">
    <div class="flex">
        <div class="logo">
            <img src="images/logo.png" alt="Hopefull Logo">
        </div>
        <nav class="navbar">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="donation.php">Donations</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="view_schedule.php">Schedules</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            
        </div>

        <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])): ?>
            <div class="account-box">
                <p>Username: <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>Email: <span><?php echo $_SESSION['user_email']; ?></span></p>
                <ul>
                    <li><a href="#"><i class="fa-regular fa-user"></i> Edit Profile</a></li>
                    <li><a href="#"><i class="fa-regular fa-envelope"></i> Inbox</a></li>
                    <li><a href="#"><i class="fa-solid fa-chart-line"></i> Analytics</a></li>
                    <li><a href="#"><i class="fa-solid fa-sliders"></i> Settings</a></li>
                    <li><a href="#"><i class="fa-regular fa-circle-question"></i> Help & Support</a></li>
                    <hr />
                    <li><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</header>


<!--
<header class=" header">
    <div class="flex">
      <div class="logo">
      <img src="images/logo.png" alt="Hopefull Logo">
      </div>
        <nav class="navbar">
         <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="donations.php">Donations</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="#">More</a>
                   <ul>
                     <li> <a href="#">MarketPlace</a> </li>
                     <li><a href="#">Terms & Conditions</a></li>
                   </ul>
                </li>
         </ul>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn"  class="fas fa-user"></div>
        </div>

        <div class="account-box">
        <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            
        <ul>
          <li>
            <a href="#">
              <i class="fa-regular fa-user"></i>
              Edit Profile
            </a>
          </li>

          <li>
            <a href="#">
              <i class="fa-regular fa-envelope"></i>
              Inbox
            </a>
          </li>

          <li >
            <a href="#">
              <i class="fa-solid fa-chart-line"></i>
              Analytics
            </a>
          </li>

          <li >
            <a href="#">
              <i class="fa-solid fa-sliders"></i>
              Settings
            </a>
          </li>

          <li >
            <a href="#">
              <i class="fa-regular fa-circle-question"></i>
              Help & Support
            </a>
          </li>
          <hr />

          <li >
            <a href="logout.php">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
              Log out
            </a>
          </li>
        </ul>
            
           
        </div>


      </div>
    </div>
</header> -->