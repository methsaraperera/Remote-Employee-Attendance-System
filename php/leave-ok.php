<?php
session_start();
require_once "../config.php";
if(isset($_POST['ok'])){
    $rowid = $_POST['rowid'];
    $sql = mysqli_query($conn, "UPDATE `tbl_leave_record` SET stat = '1' WHERE rowid = '$rowid'");
    echo '<meta http-equiv="refresh" content="0; URL=../leave.php" />';
}
?>