<?php
session_start();
require_once "../config.php";
if(!isset($_SESSION['forgot'])){
	header("location: ../login");
}
$uid = $_SESSION['forgot'];
if(isset($_POST['submit']))
{
    $sa1 = strtolower($_POST['sa1']);
    $sa2 = strtolower($_POST['sa2']);
    $sa3 = strtolower($_POST['sa3']);
    $sql = mysqli_query($conn, "SELECT sa1, sa2, sa3 FROM tbl_employee WHERE Emp_ID= '{$uid}'");
    if(mysqli_num_rows($sql) > 0){
      $row = mysqli_fetch_assoc($sql);
      $sadb1 = strtolower($row['sa1']);
      $sadb2 = strtolower($row['sa2']);
      $sadb3 = strtolower($row['sa3']);     
    }
    if($sa1 == $sadb1 && $sa2 == $sadb2 && $sa3 == $sadb3){
        echo '<meta http-equiv="refresh" content="0; URL=../reset.php"/>';
        $_SESSION['reset'] = 0;  
    }
    else{
		echo '<meta http-equiv="refresh" content="0; URL=../security-checkup.php?status=invalid" />';
    }
}
?>