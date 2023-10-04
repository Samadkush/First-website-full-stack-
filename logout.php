<?php
// Start the session (this should be at the beginning of the PHP script)
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: index.php");
exit();
?>
