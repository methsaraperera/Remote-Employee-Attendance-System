<?php
session_start();
require_once "../../config.php";
if(isset($_POST['add']))
{
    $name = ($_POST['name']);
    $annual = ($_POST['annual']);
    $casual = ($_POST['casual']);
    $sick = ($_POST['sick']);
    $maxot = ($_POST['maxot']);
    $sqlread = mysqli_query($conn, "SELECT * FROM `tbl_emp_types` WHERE name = '$name'");
    if(!mysqli_num_rows($sqlread) > 0){ 
        $sqlwrite = mysqli_query($conn, "INSERT INTO `tbl_emp_types` (`name`,`max_ot_hours`)VALUES ('$name', '$maxot')");
        if($sqlwrite){
            $sqlread2 = mysqli_query($conn, "SELECT typeid FROM `tbl_emp_types` WHERE name = '$name'");
            if(mysqli_num_rows($sqlread2) > 0){ 
                $row2 = mysqli_fetch_assoc($sqlread2);{
                    $typeid = $row2['typeid'];
                    $sqlwrite2 = mysqli_query($conn, "INSERT INTO `tbl_leave_type` (`emp_type_id`, `annual`, `casual`, `sick`)VALUES ('$typeid', '$annual', '$casual', '$sick')");
                }
            }
        }
        echo '<meta http-equiv="refresh" content="0; URL=../employee-types.php?status=success" />'; 
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../employee-types.php?status=namerepeat" />'; 
    }
}
?>