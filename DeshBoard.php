<?php
session_start();
error_reporting(0);

   if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
   {
      header('Location:index.php');
   }

?>
<?php include('menu.php');?>
<br>
<h1>DASHBOARD</h1>
</body>
</html>