<?php
session_start();
error_reporting(1);

 if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
 {
    header('Location:index.php');
 }

include "webonisePDO/DBFunctions.php";
$obj = new DBFunctions();


//add department

if(isset($_REQUEST['sub']))
{

    $empid  = $_REQUEST['id'];
    $deptid =$_REQUEST['dept'];
    $deptFromdate = $_REQUEST['dept-fromdate'];
    $depttodate  = $_REQUEST['dept-todate'];
    $date      = date("Y-m-d H:i:s");

    $insertdata = array('employee_id' =>$empid,'department_id'=> $deptid,'from_date'=>$deptFromdate,'to_date'=>$depttodate,'created' => $date, 'modified' => $date);
    $count = $obj->insert('departments_employees', $insertdata);
}



if($_GET['id'] != NULL) {

    $id = $_GET['id'];
    $where = array("id='" . $id . "'");
    $obj->select()->from('employees')->where($where)->run();
    $empData = $obj->resultSet;
    unset($obj->query);

    //get dept detail

    $where = array("employee_id='" . $id . "'");
    $obj->select(array('department_id','from_date','to_date'))->from('departments_employees')->where($where)->run();
    $salData = $obj->resultSet;
    unset($obj->query);


    //current Department
    $where = array("employee_id='" . $id . "'");
    $obj->select(array('department_id'))->from('departments_employees')->where($where)->orderby('created')->limit(1)->run();
    $currentdept = $obj->resultSet;
    unset($obj->query);

}

?>
<?php include('menu.php');?>
<br>
<h1>Employee Department Detail</h1>
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
        <td>CURRENT DEPARTMENT</td>
        <td><?php echo $obj->getDeptName( $currentdept[0]['department_id'] ); ?></td>
    </tr>
    <table border="1">
        <tr>
            <td>DEPARTMENT</td>
            <td>FROM-DATE</td>
            <td>TO-DATE</td>
        </tr>
        <?php
        if($obj->resultSetColumnCount > 0) {

            foreach ($salData as $data) {
                ?>
                <tr>
                    <td><?php echo $obj->getDeptName( $data['department_id'] ); ?></td>
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


<form action="empDeptView.php?id=<?php echo $id?>" method="post">
 <table border="1">
    <tr>
        <td colspan="6"><h1>Add Department</h1></td>
    </tr>
     <tr>
         <td>Choose Deparment</td>
         <td>
             <input type="hidden" name="id" value="<?php echo $id ?>">
             <?php $obj->select(array('id','name'))->from('departments')->run();
             $data = $obj->resultSet;
             ?>
             <select name="dept">
                 <?php foreach($data as $val){?>
                     <option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
                 <?php } ?>
             </select>
         </td>
         <td>From-Date</td>
         <td><input type="date" name="dept-fromdate"></td>
         <td>To-Date</td>
         <td><input type="date" name="dept-todate"></td>
     </tr>
     <tr>
         <td colspan="6" align="center"><input type="submit" name="sub" value="ADD Department  "></td>
     </tr>
 </table>
</form>