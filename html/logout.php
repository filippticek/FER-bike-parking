<?php
   session_start();
ob_start();
   if(session_destroy()) {
      header("Location: login.php");
   }

if (isset($_SESSION['login_user'])) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    header("Location: login.php");
}
?>
