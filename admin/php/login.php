<?php
session_start();
require_once "../../config.php";
if(isset($_POST['Login']))
{
    $email = ($_POST['email']);
    $pw = ($_POST['password']);
    $sql = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE Admin_Email= '{$email}'");
    if(mysqli_num_rows($sql) > 0){
      $row = mysqli_fetch_assoc($sql);
      $db_pw = $row['Admin_Password'];
      $adminid = $row['Admin_ID'];
      if($pw === $db_pw){
        echo '<meta http-equiv="refresh" content="0; URL=../dashboard.php"/>';
        $_SESSION['adminid'] = $adminid;
      }
      else{
        setcookie("invalid", "1", time() + 5, "/");
		    echo '<meta http-equiv="refresh" content="0; URL=../login.php?status=invalid" />';
      }
    }
    else{
      setcookie("invalid", "1", time() + 5, "/");
		    echo '<meta http-equiv="refresh" content="0; URL=../login.php?status=nouser" />';
    }
}
?>