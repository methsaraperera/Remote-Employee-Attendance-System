<?php
session_start();
require_once "../../config.php";
if(isset($_POST['Accept']))
{
    $rowid = ($_POST['rowid']);
    $status = "Approved";
    $sqlwrite = mysqli_query($conn, "UPDATE tbl_leave_record SET status = '$status' WHERE rowid = '$rowid'");
    echo '<meta http-equiv="refresh" content="0; URL=../leave-requests.php?status=approved"/>';
}
elseif(isset($_POST['Decline']))
{
    $rowid = ($_POST['rowid']);
    $status = "Declined";
    $sqlwrite = mysqli_query($conn, "UPDATE tbl_leave_record SET status = '$status' WHERE rowid = '$rowid'");
    echo '<meta http-equiv="refresh" content="0; URL=../leave-requests.php?status=del"/>';
}
?>