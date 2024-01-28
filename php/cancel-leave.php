<?php
session_start();
require_once "../config.php";
if(isset($_POST['cancel'])){
    $rowid = $_POST['rowid'];
    echo $rowid;
    $sql2 = mysqli_query($conn, "UPDATE tbl_leave_record SET status = 'Canceled' WHERE rowid = '$rowid'");
    echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=can-true" />';
}
?>