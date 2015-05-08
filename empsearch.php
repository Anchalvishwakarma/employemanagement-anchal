<?php
session_start();
error_reporting(1);

if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
{
    header('Location:index.php');
}

include "webonisePDO/DBFunctions.php";
$obj = new DBFunctions();




   if( isset($_REQUEST['sub']) )
  {
      $id = trim($_REQUEST['search']);
      $data  = $obj->getEmployeeData(7);


  }



?>
<?php include('menu.php');?>
<br/>
<br/>
<br/>
<form action="" method="post">
<table style="width: 100%;height: 50px;" border="1">
   <td align="center">EMP-ID <input type="text"  name="search">
       <input type="submit" name="sub" value="SEARCH" width="60"></td>
</table>
    </form>

  <?php  if(isset( $data )) {?>
    <table border="1">
        <tr>
            <td>Current Manager</td>
            <td>Current SALARY </td>
            <td>Current Department</td>
            <td>Job Title</td>
            <td>Date of Birth</td>
            <td>Gender</td>
            <td>Hire Date</td>
        </tr>
        <?php foreach($data as $record){?>
                <tr>
                    <td><?php echo $record['current_manager']?></td>
                    <td><?php echo $record['current_salary']?></td>
                    <td><?php echo $record['current_department']?></td>
                    <td><?php echo $record['job_title']?></td>
                    <td><?php echo $record['DOB']?></td>
                    <td><?php echo ($record['gender']=='M')?'MALE':'FEMALE' ;?></td>
                    <td><?php echo $record['hire_date']?></td>
                </tr>
        <?php } ?>
    </table>
  <?php } ?>