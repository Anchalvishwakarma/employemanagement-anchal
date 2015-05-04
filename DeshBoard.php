<?php
session_start();
error_reporting(0);

   if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
   {
      header('Location:index.php');
   }


?>
<a href="logout.php">LOGOUT</a>