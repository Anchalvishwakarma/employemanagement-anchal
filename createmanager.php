<?php
session_start();
error_reporting(0);

if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
{
    header('Location:index.php');
}
include "webonisePDO/DBFunctions.php";
$obj = new DBFunctions();

$obj->select(array('id','name'))->from('departments')->run();
$data = $obj->resultSet;


  if(isset($_REQUEST['sub']))
  {
      $id        = $_REQUEST['mang_id'];
      $dept      = $_REQUEST['dept'];
      $fromdate  = $_REQUEST['fromdate'];
      $todate    = $_REQUEST['todate'];


      $date = date("Y-m-d H:i:s");
      $insertdata = array('manager_id' =>$id,'from_date'=>$fromdate,'to_date'=>$todate,'department_id'=> $dept, 'created' => $date, 'modified' => $date);
      $count = $obj->insert('departments_managers', $insertdata);
      if($count > 0){$msg="Record Inserted";}else{$msg="Error in insertion ";}

  }

?>
<?php include('menu.php');?>
<br>
<h1>Create Manager</h1>
<?php if( isset($msg)){?>
    <div style="height:25px;width: 80%;background-color: coral;text-align: center;color: red;font-size: 15px;"><?php echo $msg?></div>
<?php } ?>
<form action="createmanager.php" method="">
    <table>
      <tr>
          <td>Manager Id</td>
          <td><input type="text" name="mang_id"></td>
      </tr>
      <tr>
          <td>Department</td>
          <td>
            <select name="dept">
             <?php foreach($data as $val){?>
               <option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
             <?php } ?>
            </select>
          </td>
      </tr>
        <tr>
            <td>From Date</td>
            <td><input type="date" name="fromdate"></td>
        </tr>
        <tr>
            <td>To Date</td>
            <td><input type="date" name="todate"></td>
        </tr>
        <tr>

            <td><input type="submit" name="sub" value="SAVE"></td>
        </tr>
    </table>
</form>