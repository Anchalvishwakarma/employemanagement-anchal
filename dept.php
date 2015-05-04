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

        if (trim($_REQUEST['dept_name'])!='') {

            $where = array("name='" . trim($_REQUEST['dept_name']). "'");
            $obj->select()->from('departments')->where($where)->run();
            $count = $obj->resultSetColumnCount;

            if( $count != 1 )
            {
                $deptname = trim($_REQUEST['dept_name']);
                $date = date("Y-m-d H:i:s");
                $insertdata = array('name' => $deptname, 'created' => $date, 'modified' => $date);
                $count = $obj->insert('departments', $insertdata);
                if($count > 0){$msg="Record Inserted";}else{$msg="Error in insertion ";}
            }  else {$msg="Department already Present";}


        } else {

            $msg = "*Required Name";
        }
    }
//end inserting new department

  if(isset($_GET['action']))
  {

      if($_GET['action']=='edit')
      {
          $id = $_REQUEST['id'];
          $where = array("id='" .$id. "'");
          $obj->select()->from('departments')->where($where)->run();
          $editdata = $obj->resultSet;

      }
      if($_GET['action']=='del')
      {
          $id = $_REQUEST['id'];
          $where = array("id='" .$id. "'");
          $obj->delete()->from('departments')->where($where)->run();
          echo "<script>alert('record deleted')</script>";
      }
  }


   //for department update
   if(isset($_REQUEST['editSub']))
  {
    $id=$_REQUEST['id'];
    $deptname =$_REQUEST['dept_name'];
    $date = date("Y-m-d H:i:s");
    $Updatedata = array('name' => $deptname,'modified' => $date);
    $where = array('id ='."'".$id."'");
    $obj->update('departments',$Updatedata)->where($where)->run();
      echo "<script>alert('record Updated')</script>";

  }


?>
<?php include('menu.php');?>
<br>
<?php if(isset($editdata)){ ?>
    <h1>Edit Department</h1>
    <?php }else{?>
   <h1>Create New Department</h1>
<?php }?>
<?php if( isset($msg)){?>
<div style="height:25px;width: 80%;background-color: coral;text-align: center;color: red;font-size: 15px;"><?php echo $msg?></div>
<?php } ?>

<form action="<?php if(isset($editdata)){echo "dept.php";}?>" method="post">
<table>

    <tr>
        <td>Name Of Department</td>
        <td>
            <input type="text" name="dept_name" value="<?php if($_GET['action']=='edit'){ echo $editdata[0]['name'];}?>">
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
 $obj->select()->from('departments')->run();
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
                 <td><?php echo $val['name']?></td>
                <td><?php echo $val['created']?></td>
                <td><?php echo $val['modified']?></td>
                <td><a href="dept.php?action=edit&id=<?php echo $val['id'] ;?>">EDIT</a>
                    |<a href="dept.php?action=del&id=<?php echo $val['id'];?>">Delete </a> </td>
               </tr>
         <?php  }

        ?>
    </tr>
</table>
</body>
</html>