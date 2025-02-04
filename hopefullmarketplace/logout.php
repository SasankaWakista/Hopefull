<?php
// Include the configuration file if needed
@include 'config.php';

// Start the session to manage user data
session_start();

// Destroy the session to log the user out
session_unset();
session_destroy();

// Redirect to the home page
header('Location: ../home.php');
exit();
?>
