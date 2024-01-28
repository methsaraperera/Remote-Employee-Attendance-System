<?php
session_start();
require_once "../../config.php";
    if(isset($_POST['delete'])){
        $id = $_POST['id'];
        $stat = $_POST['confirm'];
        if($stat == "CONFIRM"){
            $sql = "DELETE FROM `tbl_employee` WHERE `tbl_employee`.`Emp_ID` = '$id'";
            if ($conn->query($sql) === TRUE) {
                echo '<meta http-equiv="refresh" content="0; URL=../employee-list.php?status=delsuccess"/>';
            }
            else{
                echo '<meta http-equiv="refresh" content="0; URL=../employee-list.php?status=delerror"/>'; 
            }
        }
        else{
            echo '<meta http-equiv="refresh" content="0; URL=../employee-list.php?status=unconfirmed"/>'; 
        }
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../employee-list.php"/>'; 
    }
?>