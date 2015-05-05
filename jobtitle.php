<?php
session_start();
error_reporting(0);


if( $_SESSION['check'] != session_id().$_SESSION['salt'] )
{
    header('Location:index.php');
}

include "webonisePDO/DBFunctions.php";
$obj = new DBFunctions();

//inserting new department

if( isset($_REQUEST['sub']) ) {

    if (trim($_REQUEST['job_title'])!='') {

        /*check same name exists or not*/
        $where = array("title='" . trim($_REQUEST['job_title']). "'");
        $obj->select()->from('job_titles')->where($where)->run();
        $count = $obj->resultSetColumnCount;

        if( $count != 1 )//record exists or not condition
        {
            $jobtitle = trim($_REQUEST['job_title']);
            $date = date("Y-m-d H:i:s");
            $insertdata = array('title' =>$jobtitle, 'created' => $date, 'modified' => $date);
            $count = $obj->insert('job_titles', $insertdata);
            if($count > 0){$msg="Record Inserted";}else{$msg="Error in insertion ";}
        }  else {$msg="Job Title already Present";}


    } else {

        $msg = "*Required job Title";
    }
}
//end inserting new department

if(isset($_GET['action']))
{

    if($_GET['action']=='edit')
    {
        $id = $_REQUEST['id'];
        $where = array("id='" .$id. "'");
        $obj->select()->from('job_titles')->where($where)->run();
        $editdata = $obj->resultSet;

    }
    if($_GET['action']=='del')
    {
        $id = $_REQUEST['id'];
        $where = array("id='" .$id. "'");
        $obj->delete()->from('job_titles')->where($where)->run();
        $msg="Record Deleted";
    }
}


//for department update
if(isset($_REQUEST['editSub']))
{
    $id=$_REQUEST['id'];
    $deptname =$_REQUEST['job_title'];
    $date = date("Y-m-d H:i:s");
    $Updatedata = array('title' => $deptname,'modified' => $date);
    $where = array('id ='."'".$id."'");
    $obj->update('job_titles',$Updatedata)->where($where)->run();
    $msg = "Record updated";

}


?>
<?php include('menu.php');?>
<br>
<?php if(isset($editdata)){ ?>
    <h1>Edit Job Title</h1>
<?php }else{?>
    <h1>Create New Job Title</h1>
<?php }?>
<?php if( isset($msg)){?>
    <div style="height:25px;width: 80%;background-color: coral;text-align: center;color: red;font-size: 15px;"><?php echo $msg?></div>
<?php } ?>

<form action="jobtitle.php" method="post">
    <table>

        <tr>
            <td>Name Of JobTitle</td>
            <td>
                <input type="text" name="job_title" value="<?php if($_GET['action']=='edit'){ echo $editdata[0]['title'];}?>">
                <?php if(isset($editdata)){?>
                    <input type="hidden" name="id" value="<?php echo $editdata[0]['id'] ;?>">
                <?php }?>
            </td>
        </tr>
        <tr>
            <?php if(isset($editdata)) { ?>
                <td><input type="submit" name="editSub" value="EDIT"></td>
            <?php }else{ ?>
                <td><input type="submit" name="sub" value="Create"></td>
            <?php } ?>

        </tr>
    </table>
</form>

<?php
$obj->select()->from('job_titles')->run();
?>

<h1>Current Records</h1>
<table border="1">

    <tr>
        <td>ID</td>
        <td>NAME</td>
        <td>Created On</td>
        <td>Modified On</td>
        <td>Action</td>
        <?php

        foreach($obj->resultSet as  $val)
        { ?>
    <tr>
        <td><?php echo $val['id']?></td>
        <td><?php echo $val['title']?></td>
        <td><?php echo $val['created']?></td>
        <td><?php echo $val['modified']?></td>
        <td><a href="jobtitle.php?action=edit&id=<?php echo $val['id'] ;?>">EDIT</a>
            |<a href="jobtitle.php?action=del&id=<?php echo $val['id'];?>">Delete </a> </td>
    </tr>
    <?php  }

    ?>
    </tr>
</table>
</body>
</html>