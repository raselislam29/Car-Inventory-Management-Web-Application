<?php
// logout.php
session_start();        // Always start the session
session_unset();        // Unset all session variables
session_destroy();      // Destroy the session
header("Location: login.php");   // Redirect back to login page
exit();
?>