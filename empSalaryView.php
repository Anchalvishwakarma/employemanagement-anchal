<?php
  session_start();
  error_reporting(1);

 if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
 {
    header('Location:index.php');
 }

include "webonisePDO/DBFunctions.php";
$obj = new DBFunctions();



//add salary
if(isset($_REQUEST['sub']))
{

    $empid  = $_REQUEST['id'];
    $salary =$_REQUEST['salary'];
    $salFromdate = $_REQUEST['sal-fromdate'];
    $saltodate  = $_REQUEST['sal-todate'];
    $date      = date("Y-m-d H:i:s");

    $insertdata = array('employee_id' =>$empid,'salary'=> $salary,'from_date'=>$salFromdate,'to_date'=>$saltodate,'created' => $date, 'modified' => $date);
    $count = $obj->insert('salaries', $insertdata);
}


if($_GET['id'] != NULL) {

    $id = $_GET['id'];
    $where = array("id='" . $id . "'");
    $obj->select()->from('employees')->where($where)->run();
    $empData = $obj->resultSet;
    unset($obj->query);

    //get salary detail

    $where = array("employee_id='" . $id . "'");
    $obj->select(array('salary','from_date','to_date'))->from('salaries')->where($where)->run();
    $salData = $obj->resultSet;
    unset($obj->query);


    //get current salary
    $obj->select(array('salary'))->from('salaries')->where($where)->orderby('created')->limit(1)->run();
    $currentSal = $obj->resultSet;
    unset($obj->query);

}
?>
<?php include('menu.php');?>
<br>
<h1>Employee Salary Detail</h1>
  <table border="1">
      <tr>
          <td>EMP-ID</td>
          <td><?php echo $empData[0]['id']?></td>
      </tr>
      <tr>
          <td>EMP NAME</td>
          <td><?php echo $empData[0]['name']?></td>
      </tr>
      <tr>
          <td>CURRENT SALARY</td>
          <td><?php echo $currentSal[0]['salary'] ?></td>
      </tr>

      <table border="1">
          <tr>
              <td>SALARY</td>
              <td>FROM-DATE</td>
              <td>TO-DATE</td>
          </tr>
          <?php
          if($obj->resultSetColumnCount > 0) {

              foreach ($salData as $data) {
                  ?>
                  <tr>
                      <td><?php echo $data['salary']?></td>
                      <td><?php echo $data['from_date']?></td>
                      <td><?php echo $data['to_date']?></td>

                  </tr>


              <?php }}else{  ?>

                <tr><td colspan="3" align="center">NO RECORD FOUND</td></tr>
         <?php }
          ?>

      </table>

  </table>
<br>
<form action="empSalaryView.php?id=<?php echo $id?>" method="post">
    <table border="1">
        <tr>
            <td colspan="6"><h1>Add salary</h1></td>
        </tr>
        <tr>
            <td>Salary</td>
            <td>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="number" name="salary">
            </td>
            <td>From-Date</td>
            <td><input type="date" name="sal-fromdate"></td>
            <td>To-Date</td>
            <td><input type="date" name="sal-todate"></td>
        </tr>
        <tr>
            <td colspan="6" align="center"><input type="submit" name="sub" value="ADD Salary"></td>
        </tr>
    </table>
</form>