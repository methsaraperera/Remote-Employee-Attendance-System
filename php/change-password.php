<?php
session_start();
require_once "../config.php";
if(isset($_POST['change'])){
    $id = $_POST['id'];
    $oldpass = $_POST['old-password'];
    $pass = $_POST['new-password'];
    $repass = $_POST['new-re-password'];
    if ($pass == $repass){
        $sql = mysqli_query($conn, "SELECT `Emp_Password` FROM `tbl_employee` WHERE `Emp_ID` = '$id'");
        $row = mysqli_fetch_assoc($sql);
        $password = $row['Emp_Password'];
        if($password == $oldpass){
            $sql2 = mysqli_query($conn, "UPDATE tbl_employee SET Emp_Password = '$pass' WHERE Emp_ID = '$id'");
            echo '<meta http-equiv="refresh" content="0; URL=../change-password.php?status=pass-changed" />';
        }
        else{
            echo '<meta http-equiv="refresh" content="0; URL=../change-password.php?status=expass" />';
        }
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../change-password.php?status=pass-error" />';
    } 
}
?>