<?php
session_start();
require_once "../../config.php";
if(isset($_POST['add']))
{
    $name = ($_POST['empname']);
    $email = ($_POST['empemail']);
    $password = ($_POST['emppassword']);
    $type = ($_POST['emptype']);
    $sqlread = mysqli_query($conn, "SELECT * FROM `tbl_employee` WHERE Emp_Email = '$email'");
    if(!mysqli_num_rows($sqlread) > 0){ 
        $sqlwrite = mysqli_query($conn, "INSERT INTO `tbl_employee` (`Emp_ID`, `Emp_Name`, `Emp_Email`, `Emp_Password`, `Emp_Type`, `SQ1`, `SA1`, `SQ2`, `SA2`, `SQ3`, `SA3`) VALUES (NULL, '{$name}', '{$email}', '{$password}', '{$type}', NULL, NULL, NULL, NULL, NULL, NULL);");
        if($sqlwrite){
            $sqlread2 = mysqli_query($conn, "SELECT * FROM tbl_employee WHERE Emp_Email = '{$email}'");
            if(mysqli_num_rows($sqlread2) > 0){
                $row2 = mysqli_fetch_assoc($sqlread2);{
                    $uid = $row2['Emp_ID'];
                }
                $sqlwritestatus = mysqli_query($conn, "INSERT INTO `tbl_emp_status` (`empid`, `status`) VALUES ('{$uid}', 'Offline')");
                
                echo '<meta http-equiv="refresh" content="0; URL=../add-user.php?status=success" />'; 
    
            }else{
                echo '<meta http-equiv="refresh" content="0; URL=../add-user.php?status=repeat" />';
            }
        }else{
            echo '<meta http-equiv="refresh" content="0; URL=../add-user.php?status=error" />';
        }
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../add-user.php?status=repeat" />'; 
    }
}
?>