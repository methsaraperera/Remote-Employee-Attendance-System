<?php
session_start();
require_once "../../config.php";
$typeid = ($_POST['typeid']);
if(isset($_POST['edit'])){
    $annual = ($_POST['annual']);
    $casual = ($_POST['casual']);
    $sick = ($_POST['sick']);
    $max = ($_POST['max']);
    $sqlread = mysqli_query($conn, "SELECT * FROM `tbl_emp_types` WHERE typeid = '$typeid'");
    if(mysqli_num_rows($sqlread) > 0){ 
        $sqlwrite = mysqli_query($conn, "UPDATE tbl_emp_types SET annual = '$annual', casual = '$casual', sick = '$sick', max_ot_hours = '$max' WHERE typeid = '$typeid'");
    echo '<meta http-equiv="refresh" content="0; URL=../employee-types.php?status=updated" />'; 
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../employee-types.php?status=error" />';
    }
}
elseif(isset($_POST['delete']))
{
    $typename = ($_POST['typename']);
    $sqlread = mysqli_query($conn, "SELECT * FROM `tbl_employee` WHERE Emp_Type = '$typename'");
    if(!mysqli_num_rows($sqlread) > 0){ 
        $sqlwrite = mysqli_query($conn, "DELETE FROM `tbl_emp_types` WHERE tbl_emp_types.typeid = '{$typeid}'");
        echo '<meta http-equiv="refresh" content="0; URL=../employee-types.php?status=deleted" />'; 
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../employee-types.php?status=filled" />'; 
    }
}
?>