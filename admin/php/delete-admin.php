<?php
session_start();
require_once "../../config.php";
$sql = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_admin`");
$row = mysqli_fetch_assoc($sql);
$count = $row['COUNT(*)'];

if(isset($_POST['delete']))
{
    if(!$count <= 1){
        $id = ($_POST['id']);
        $sql = "DELETE FROM `tbl_admin` WHERE `tbl_admin`.`Admin_ID` = $id";
        if ($conn->query($sql) === TRUE) {
            echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=delsuccess" />';
        }
        else{
            echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=delerror" />'; 
        }
    }
    else{
       echo '<meta http-equiv="refresh" content="0; URL=../users.php?status=delerroruser" />';
    }
}
?>