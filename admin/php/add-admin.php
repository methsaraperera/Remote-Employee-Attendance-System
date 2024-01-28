<?php
session_start();
require_once "../../config.php";
if(isset($_POST['add']))
{
    $name = ($_POST['name']);
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $sqlread = mysqli_query($conn, "SELECT * FROM `tbl_admin` WHERE Admin_Email = '$email'");
    if(!mysqli_num_rows($sqlread) > 0){ 
        $sqlwrite = mysqli_query($conn, "INSERT INTO `tbl_admin` (`Admin_Name`, `Admin_Email`, `Admin_Password`)VALUES ('$name', '$email', '$password')");
        echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=success" />'; 
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=repeat" />'; 
    }
}
?>