<?php
session_start();
require_once "../../config.php";
if(isset($_POST['reset'])){
    $email = $_POST['email'];
    $assist = $_POST['assist'];
    $id = explode(" ", $assist);
    $aid =  $id[0];
    $sqlread = mysqli_query($conn, "SELECT * FROM `tbl_admin` WHERE Admin_Email = '$email'");
    if(mysqli_num_rows($sqlread) > 0){ 
        $sqlwrite = mysqli_query($conn, "UPDATE `tbl_admin` SET Status = '$aid' WHERE Admin_Email = '$email'");
        echo '<meta http-equiv="refresh" content="0; URL=../forgot-password.php?status=success"/>'; 
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../forgot-password.php?status=invalid"/>'; 
    }
}
elseif(isset($_POST['reset-ok'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordre = $_POST['passwordre'];
    if(!$password == NULL AND !$passwordre == NULL){
        if($password == $passwordre){
            $sqlwrite = mysqli_query($conn, "UPDATE `tbl_admin` SET Admin_Password = '$password' WHERE Admin_Email = '$email'");
            $sqlwrite = mysqli_query($conn, "UPDATE `tbl_admin` SET Status = NULL WHERE Admin_Email = '$email'");
            echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=success-reset"/>'; 
        }
        else{
            echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=unmatch-reset"/>';
        }
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=fields-reset"/>';
    }
    
}
elseif(isset($_POST['reset-no'])){
    $email = $_POST['email'];
    $sqlwrite = mysqli_query($conn, "UPDATE `tbl_admin` SET Status = NULL WHERE Admin_Email = '$email'");
    echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=del-reset"/>'; 
}
?>