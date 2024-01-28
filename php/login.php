<?php
session_start();
require_once "../config.php";
if(isset($_POST['Login']))
{
    $email = ($_POST['email']);
    $pw = ($_POST['password']);
    $sql = mysqli_query($conn, "SELECT * FROM tbl_employee WHERE Emp_Email= '{$email}'");
    if(mysqli_num_rows($sql) > 0){
      $row = mysqli_fetch_assoc($sql);
      $db_pw = $row['Emp_Password'];
      $uid = $row['Emp_ID'];
      if($pw === $db_pw){
        echo '<meta http-equiv="refresh" content="0; URL=../index.php" />';
        $_SESSION['uid'] = $uid;
      }
      else{
        setcookie("invalid", "1", time() + 5, "/");
		    echo '<meta http-equiv="refresh" content="0; URL=../login.php?status=inpassword" />';
      }
    }
    else{
      setcookie("invalid", "1", time() + 5, "/");
		    echo '<meta http-equiv="refresh" content="0; URL=../login.php?status=inemail" />';
    }
}
?>