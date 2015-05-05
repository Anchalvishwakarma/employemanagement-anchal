<?php
session_start();
error_reporting(0);

 if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
 {
    header('Location:index.php');
 }

include "webonisePDO/DBFunctions.php";
$obj = new DBFunctions();


//Creating Employee
    if(isset($_REQUEST['Save']))
   {

      $emp_name    = $_REQUEST['emp_name'];
      $emp_manager = $_REQUEST['emp_manager'];
      $dept        = $_REQUEST['dept'];
      $deptFromdate = $_REQUEST['dept-fromdate'];
      $depttodate   =$_REQUEST['dept-todate'];

      $jobtitle    = $_REQUEST['jobtitle'];
      $jobFromdate = $_REQUEST['job-fromdate'];
      $jobtodate   =$_REQUEST['job-todate'];

      $salary      =$_REQUEST['salary'];
      $salFromdate = $_REQUEST['sal-fromdate'];
      $saltodate   =$_REQUEST['sal-todate'];

      $hire_date   = $_REQUEST['hire_date'];
      $gender      = $_REQUEST['gender'];
      $DOB         = $_REQUEST['DOB'];

      $date      = date("Y-m-d H:i:s");

      $insertdata = array('name' =>$emp_name,'manager_id'=>$emp_manager,'dob'=> $DOB,'gender'=>$gender,'hire_date'=>$hire_date,'created' => $date, 'modified' => $date);
      $count = $obj->insert('employees', $insertdata);

      $empId = $obj->getLastInsertedId();

       unset($obj->query);
       $insertdata = array('employee_id' =>$empId,'department_id'=> $dept,'from_date'=>$deptFromdate,'to_date'=>$depttodate,'created' => $date, 'modified' => $date);
       $count = $obj->insert('departments_employees', $insertdata);

       unset($obj->query);
       $insertdata = array('employee_id' =>$empId,'job_title_id'=> $jobtitle,'from_date'=>$jobFromdate,'to_date'=>$jobtodate,'created' => $date, 'modified' => $date);
       $count = $obj->insert('employees_titles', $insertdata);

       unset($obj->query);
       $insertdata = array('employee_id' =>$empId,'salary'=> $salary,'from_date'=>$salFromdate,'to_date'=>$saltodate,'created' => $date, 'modified' => $date);
       $count = $obj->insert('salaries', $insertdata);


   }



?>
<?php include('menu.php');?>
<br>
<h1>Employee Registration</h1>
<form action="emp.php" method="post">

    <table>
        <tr>
            <td>EMP NAME</td>
            <td><input type="text" name="emp_name"></td>
        </tr>
        <tr>
            <td>Department</td>
            <td><?php $obj->select(array('id','name'))->from('departments')->run();
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
            <td>Job Title</td>
            <td><?php
                $obj->select(array('id','title'))->from('job_titles')->run();
                $data = $obj->resultSet;
                ?>
                <select name="jobtitle">

                    <?php foreach($data as $val){?>
                        <option value="<?php echo $val['id']?>"><?php echo $val['title']?></option>
                    <?php } ?>
                </select>
            </td>
            <td>From-Date</td>
            <td><input type="date" name="job-fromdate"></td>
            <td>To-Date</td>
            <td><input type="date" name="job-todate"></td>
        </tr>
        <tr>
            <td>Manager</td>
            <td>
                <select name="emp_manager">
                     <option value="">SELECT</option>
                <?php
                  $obj->select(array('manager_id'))->from('departments_managers')->run();
                  $data = $obj->resultSet;
                  unset($obj->query);
                  foreach($data as $id)
                  {
                       $where = array('id ='."'".$id['manager_id']."'");
                       $obj->select(array('id','name'))->from('employees')->where($where)->run();
                       $emp_data = $obj->resultSet;
                   ?>
                      <option value="<?php echo $emp_data[0]['id'] ;?>"><?php echo $emp_data[0]['name']; ?></option>
                   <?php
                  }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Salary</td>
            <td><input type="number" name="salary"></td>
            <td>From-Date</td>
            <td><input type="date" name="sal-fromdate"></td>
            <td>To-Date</td>
            <td><input type="date" name="sal-todate"></td>
        </tr>
        <tr>
            <td>Hire Date</td>
            <td><input type="date" name="hire_date"></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><input type="radio" name="gender" checked value="M">MALE &nbsp; <input type="radio" value="F" name="gender">female</td>
        </tr>
        <tr>
            <td>DOB</td>
            <td><input type="date" name="DOB"></td>
        </tr>
        <tr>
            <td><input type="submit" name="Save" value="Save"></td>
        </tr>
    </table>
</form>
<?php
   $obj->select()->from('employees')->run();
   $AllempData = $obj->resultSet;
   print_r($AllempData);
?>
        <h1>Current Employee</h1>

    <table border="1">
        <tr>
            <td colspan="8" align="center"><h1>Employee Detail</h1></td>
        </tr>
        <tr>
            <td>Emp ID</td>
            <td>Emp NAME</td>
            <td>MANAGER</td>
            <td>HIRE DATE</td>
            <td>GENDER</td>
            <td>DOB</td>
            <td>SALARY</td>
            <td>DEPARTMENT</td>
        </tr>
        <?php
            foreach($AllempData as $val)
            { ?>
                <tr>
                    <td><?php echo $val['id']?></td>
                    <td><?php echo $val['name'] ?></td>
                    <td><?php echo ($val['manager_id']==0 )?'MANAGER':'';?></td>
                    <td><?php echo $val['dob'] ?></td>
                    <td><?php echo $val['gender'] ?></td>
                    <td><?php echo $val['hire_date'] ?></td>
                    <td><?php echo $val[''] ?></td>
                    <td><?php echo $val[''] ?></td>
                 </tr>

       <?php  } ?>
    </table>


</body>
</html>