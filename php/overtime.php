<?php
session_start();
require_once "../config.php";
if(isset($_POST['yes'])){
    $rowid = $_POST['rowid'];
    $sql = mysqli_query($conn, "UPDATE `tbl_attendance` SET ot_stat = '0' WHERE rowid = '$rowid'");
    echo '<meta http-equiv="refresh" content="0; URL=../index.php" />';
}
elseif(isset($_POST['no'])){
    $rowid = $_POST['rowid'];
    $sql = mysqli_query($conn, "UPDATE `tbl_attendance` SET ot_stat = '0', ot_time = NULL WHERE rowid = '$rowid'");
    echo '<meta http-equiv="refresh" content="0; URL=../index.php" />';
}
?>