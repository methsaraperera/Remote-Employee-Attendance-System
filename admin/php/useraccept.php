<?php
session_start();
require_once "../../config.php";
if(isset($_POST['Accept']))
{
    $request_id = ($_POST['request_id']);
    $type = ($_POST['type']);
    $sqlread = mysqli_query($conn, "SELECT * FROM `tbl_signuprequest` WHERE request_id = '$request_id'");
    if(mysqli_num_rows($sqlread) > 0){ 
        $row = mysqli_fetch_assoc($sqlread);
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $sq1 = $row['sq1'];
        $sa1 = $row['sa1'];
        $sq2 = $row['sq2'];
        $sa2 = $row['sa2'];
        $sq3 = $row['sq3'];
        $sa3 = $row['sa3'];
        $request_id = $row['request_id'];
        $date = $row['date'];
    }
    $sqlwrite = mysqli_query($conn, "INSERT INTO `tbl_employee` (`Emp_ID`, `Emp_Name`, `Emp_Email`, `Emp_Password`, `Emp_Type`, `SQ1`, `SA1`, `SQ2`, `SA2`, `SQ3`, `SA3`)
                                VALUES (NULL,'{$name}', '{$email}','{$password}','{$type}', '{$sq1}', '{$sa1}', '{$sq2}', '{$sa2}', '{$sq3}', '{$sa3}')");
    
    if($sqlwrite){
        $sqlread2 = mysqli_query($conn, "SELECT * FROM tbl_employee WHERE Emp_Email = '{$email}'");
        if(mysqli_num_rows($sqlread2) > 0){
            $row2 = mysqli_fetch_assoc($sqlread2);{
                $uid = $row2['Emp_ID'];
            }
            $sqlwritestatus = mysqli_query($conn, "INSERT INTO `tbl_emp_status` (`empid`, `status`) VALUES ('{$uid}', 'Offline')");
            $sqldelete = mysqli_query($conn, "DELETE FROM `tbl_signuprequest` WHERE tbl_signuprequest.request_id = '{$request_id}'");
            echo '<meta http-equiv="refresh" content="0; URL=../requests.php?status=success" />'; 

        }else{
            echo '<meta http-equiv="refresh" content="0; URL=../requests.php?status=repeat" />';
        }
    }else{
        echo '<meta http-equiv="refresh" content="0; URL=../requests.php?status=error" />';
    }
}
elseif(isset($_POST['Delete']))
{
    $request_id = ($_POST['request_id']);
    $sqldelete = mysqli_query($conn, "DELETE FROM `tbl_signuprequest` WHERE tbl_signuprequest.request_id = '{$request_id}'");
    setcookie("delete", "1", time() + 5, "/");
    echo '<meta http-equiv="refresh" content="0; URL=../requests.php" />';
}
?>