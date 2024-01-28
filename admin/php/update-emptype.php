<?php
session_start();
require_once "../../config.php";
if(isset($_POST['Update'])){
    $id = $_POST['id'];
    $type = $_POST['type'];
    $sql = mysqli_query($conn, "UPDATE tbl_employee SET Emp_Type = '$type' WHERE Emp_ID = '$id'");
    echo '<meta http-equiv="refresh" content="0; URL=../employee-data.php?id='.$id.'&et=success" />'; 
}
?>