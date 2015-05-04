<?php
       session_start();
       error_reporting(0);


      if( $_SESSION['check'] == session_id().$_SESSION['salt'] )
     {
        header('Location:DeshBoard.php');
     }


     if ( isset( $_REQUEST['sub'] )  && $_REQUEST['sub']=='Login')
     {
         include "webonisePDO/DBFunctions.php";
         $obj = new DBFunctions();
         $userid   = trim( $_REQUEST['user']);
         $password = trim( $_REQUEST['password'] );

         if($userid !='' and $password !='' ) {


             $where = array("userid ='" . $userid . "'", 'and', "pass='" . $password . "'");
             $obj->select()->from('admin_login_tbl')->where($where)->run(1);
              if($obj->resultSetColumnCount > 0)
             {
                 $_SESSION['salt'] ='sdfhkhdfkhdkshdfhsdkf8759hsd473'.time().$_SERVER['REMOTE_ADDR'];
                 $_SESSION['check']=session_id().$_SESSION['salt'];
                 header('Location:DeshBoard.php');
             }
              else{$msg="Invalid UserID Password";}
         }else{
             $msg="* Required UserID Password";
         }
     }

?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>EMP-MANAGEMENT</title>
  <link rel="stylesheet" href="css/indexCss.css">
    <script src="js/prefixfree.min.js"></script>

</head>

<body>

  <div class="body"></div>
		<div class="grad"></div>

		<div class="header">
            <?php if(isset($msg)){?>
                <div id="errorMSG"><?php echo $msg ;unset($msg)?></div>
            <?php }?>
			<div>Employee<span>Management</span></div>
		</div>
		<br>
		<div class="login">
            <form method="post" action="">
				<input type="text" placeholder="username" name="user"><br>
				<input type="password" placeholder="password" name="password"><br>
				<input type="submit"  name="sub" value="Login">
            </form>
        </div>

  <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>

</body>

</html>