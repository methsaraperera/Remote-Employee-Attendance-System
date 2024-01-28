<?php
session_start();
require_once "../config.php";
if(isset($_POST['Submit']))
$uid = $_SESSION['uid'];
{
    $pw = ($_POST['password']);
    $pwre = ($_POST['passwordre']);
    $sq1 = ($_POST['sq1']);
    $sa1 = ($_POST['sa1']);
    $sq2 = ($_POST['sq2']);
    $sa2 = ($_POST['sa2']);
    $sq3 = ($_POST['sq3']);
    $sa3 = ($_POST['sa3']);
    if ($pw == $pwre){
        $sql = mysqli_query($conn, "UPDATE tbl_employee SET Emp_Password = '$pw', SQ1 = '$sq1', SA1 = '$sa1', SQ2 = '$sq2', SA2 = '$sa2', SQ3 = '$sq3', SA3 = '$sa3' WHERE Emp_ID = '$uid'");
        if($sql){
            echo '<meta http-equiv="refresh" content="0; URL=../login.php?status=nuser" />';
        }
    }
    else{
        echo '<meta http-equiv="refresh" content="0; URL=../new-user.php?status=pass" />';
    }
}
?>