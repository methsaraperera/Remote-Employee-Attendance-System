<?php
session_start();
if(!isset($_SESSION['forgot']) && !isset($_SESSION['reset'])){
	header("location: login");
}
$uid = $_SESSION['forgot'];
require_once "../config.php";
if(isset($_POST['reset'])){
    $pass = $_POST['new-password'];
    $repass = $_POST['new-re-password'];
    if ($pass == $repass){
        $sql2 = mysqli_query($conn, "UPDATE tbl_employee SET Emp_Password = '$pass' WHERE Emp_ID = '$uid'");
        unset($_SESSION['forgot']);
        unset($_SESSION['reset']);
        echo '<meta http-equiv="refresh" content="0; URL=../login.php?status=reset-success" />';   
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../reset.php?status=unmatching" />';
    } 
}
?>