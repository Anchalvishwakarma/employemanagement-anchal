<?php
session_start();
error_reporting(1);

if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
{
    header('Location:index.php');
}

include "webonisePDO/DBFunctions.php";
$obj = new DBFunctions();
?>
<?php include('menu.php');?>
<br/>
<br/>
<br/>
<table style="width: 100%;height: 50px;" border="1">
   <td align="center">EMP-ID <input type="text"  name="search"> <input type="submit" name="sub" value="SEARCH" width="60"></td>
</table>