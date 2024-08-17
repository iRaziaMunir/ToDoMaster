<?php
session_start();

if(isset($_SESSION['user_name'])){
  $user_name = $_SESSION['user_name'];
}

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

header("Location: login.php");
exit();

?>