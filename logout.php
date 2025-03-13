<?php
session_start();

// Destroy the session to log the user out
session_unset();  // Unset all session variables
session_destroy();  // Destroy the session

// Redirect to login page
header("Location: home.php");
exit;
?>
