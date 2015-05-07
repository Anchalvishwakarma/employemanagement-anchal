<?php
session_start();
error_reporting(1);

 if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
 {
     header('Location:index.php');
 }

include "webonisePDO/DBFunctions.php";
$obj = new DBFunctions();


//add job-title

 if(isset($_REQUEST['sub']))
 {

    $empid  = $_REQUEST['id'];
    $jobtitle =$_REQUEST['jobtitle'];
    $jobFromdate = $_REQUEST['job-fromdate'];
    $jobtodate  = $_REQUEST['job-todate'];
    $insertdata = array('employee_id' =>$empid,'job_title_id'=> $jobtitle,'from_date'=>$jobFromdate,'to_date'=>$jobtodate,'created' => $date, 'modified' => $date);
    $count = $obj->insert('employees_titles', $insertdata);
 }




if($_GET['id'] != NULL) {

    $id = $_GET['id'];
    $where = array("id='" . $id . "'");
    $obj->select()->from('employees')->where($where)->run();
    $empData = $obj->resultSet;
    unset($obj->query);

    //get salary detail

    $where = array("employee_id='" . $id . "'");
    $obj->select(array('job_title_id','from_date','to_date'))->from('employees_titles')->where($where)->run();
    $salData = $obj->resultSet;

}
?>
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
                    <td><?php echo $obj->getJobTitleName( $data['job_title_id'] ); ?></td>
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

<form action="empJobtitleView.php?id=<?php echo $id?>" method="post">
    <table border="1">
        <tr>
            <td colspan="6"><h1>Add Job-Title</h1></td>
        </tr>
        <tr>
            <td>Job Title</td>
            <td>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <?php
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
            <td colspan="6" align="center"><input type="submit" name="sub" value="ADD Department  "></td>
        </tr>
    </table>
</form>