<?php
  session_start();
  unset($_SESSION['check']);
  unset($_SESSION['salt']);
  session_destroy();
  header('Location:index.php');
?>