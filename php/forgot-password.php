<?php
session_start();
require_once "../config.php";
if(isset($_POST['forgot']))
{
    $email = ($_POST['email']);
    $sql = mysqli_query($conn, "SELECT Emp_ID FROM tbl_employee WHERE Emp_Email= '{$email}'");
    if(mysqli_num_rows($sql) > 0){
      $row = mysqli_fetch_assoc($sql);
      $uid = $row['Emp_ID'];
        echo '<meta http-equiv="refresh" content="0; URL=../security-checkup.php" />';
        $_SESSION['forgot'] = $uid;  
    }
    else{
		    echo '<meta http-equiv="refresh" content="0; URL=../forgot-password.php?status=invalid" />';
    }
}
?>