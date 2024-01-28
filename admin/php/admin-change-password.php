<?php
session_start();
require_once "../../config.php";
if(isset($_POST['Change'])){
    $id = $_POST['id'];
    $oldpass = $_POST['pass-old'];
    $pass = $_POST['pass-change'];
    $repass = $_POST['pass-change-re'];
    if ($pass == $repass){
        $sql = mysqli_query($conn, "SELECT `Admin_Password` FROM `tbl_admin` WHERE `Admin_ID` = '$id'");
        $row = mysqli_fetch_assoc($sql);
        $password = $row['Admin_Password'];
        if($password == $oldpass){
            $sql2 = mysqli_query($conn, "UPDATE tbl_admin SET Admin_Password = '$pass' WHERE Admin_ID = '$id'");
            echo '<meta http-equiv="refresh" content="0; URL=../change-password.php?ps=pass-changed" />';
        }
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../change-password.php?err=pass-error" />';
    }    
}
?>