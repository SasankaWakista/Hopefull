<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . $msg . '</span>
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
                <li><a href="../home.php">Back</a></li>
                <li><a href="hopefullmarketplace/home.php">Market Place</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                
            </ul>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>
    </div> 
</header>
