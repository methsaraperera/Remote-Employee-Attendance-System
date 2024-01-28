<?php
session_start();
require_once "../../config.php";
if(isset($_POST['Change'])){
    $id = $_POST['id'];
    $pass = $_POST['pass-change'];
    $pass_re = $_POST['pass-change-re'];
    if ($pass == $pass_re){
        $sql = mysqli_query($conn, "UPDATE tbl_employee SET Emp_Password = '$pass' WHERE Emp_ID = '$id'");
        echo '<meta http-equiv="refresh" content="0; URL=../employee-data.php?id='.$id.'&ps=pass-changed" />'; 
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../employee-data.php?id='.$id.'&err=pass-error" />'; 
    } 
}
?>