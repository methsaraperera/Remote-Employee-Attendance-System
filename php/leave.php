<?php
session_start();
require_once "../config.php";
if(!isset($_SESSION['uid'])){
	header("location: login");
}
$uid = $_SESSION['uid'];
$date = $_POST['date'];
$leavetype = $_POST['type'];
$description = $_POST['description'];
$read = mysqli_query($conn, "SELECT stat_in, stat_out FROM `tbl_attendance` WHERE Emp_ID = '$uid' ORDER BY `tbl_attendance`.`rowID` DESC LIMIT 1");
$rowread = mysqli_fetch_assoc($read);
$statin = $rowread["stat_in"];
$statout = $rowread["stat_out"];
$currYear = date('Y');
$startYear = $currYear . "-01-01";
$endYear = $currYear . "-12-31";
$sql1 = mysqli_query($conn, "SELECT Emp_Type FROM tbl_employee WHERE Emp_ID = '$uid'");
$row1 = mysqli_fetch_assoc($sql1);{
    $type = $row1["Emp_Type"];
    $sql2 = mysqli_query($conn, "SELECT * FROM tbl_emp_types WHERE name = '$type'");
    $row2 = mysqli_fetch_assoc($sql2);{
        $typeid = $row2["typeid"];
        $sql3 = mysqli_query($conn, "SELECT * FROM tbl_leave_type WHERE emp_type_id = '$typeid'");
        $row3 = mysqli_fetch_assoc($sql3);{
            $tl1 = $row3["annual"];
            $tl2 = $row3["casual"];
            $tl3 = $row3["sick"];
        }  
    }
}
$status = "In Review";
if($statin == 1 && $statout == 1){
    if($leavetype == "annual")
    {   
        $sqlannual = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$uid' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'annual'");
		$rowannual = mysqli_fetch_assoc($sqlannual);
		$annual = $rowannual['COUNT(*)'];
        $annualsub = $tl1 - $annual;
        $stat = "0";
        if($annualsub > 0){
            $sql = "INSERT INTO `tbl_leave_record` (`rowid`, `empid`, `date`, `leave_type`, `descripition`, `status`, `stat`) VALUES (NULL, '{$uid}', '{$date}', '{$leavetype}', '{$description}', '{$status}', '{$stat}')";
            if ($conn->query($sql) === TRUE) {
                echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=success"/>';
            }
            else{
                echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=failed"/>';
            }
        }
        else{
            echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=noannual"/>';
        }
    }
    elseif($leavetype == "casual")
    {
        $sqlcasual = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$uid' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'casual'");
		$rowcasual = mysqli_fetch_assoc($sqlcasual);
		$casual = $rowcasual['COUNT(*)'];
        $casualsub = $tl1 - $casual;
        $stat = "0";
        if($casualsub > 0){
            $sql = "INSERT INTO `tbl_leave_record` (`rowid`, `empid`, `date`, `leave_type`, `descripition`, `status`, `stat`) VALUES (NULL, '{$uid}', '{$date}', '{$leavetype}', '{$description}', '{$status}', '{$stat}')";
            if ($conn->query($sql) === TRUE) {
                echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=success"/>';
            }
            else{
                echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=failed"/>';
            }
        }
        else{
            echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=nocasual"/>';
        }
    }
    elseif($leavetype == "sick")
    {
        $sqlsick = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$uid' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'sick'");
		$rowsick = mysqli_fetch_assoc($sqlsick);
		$sick = $rowsick['COUNT(*)'];
        $sicksub = $tl1 - $sick;
        $stat = "0";
        if($sicksub > 0){
            $sql = "INSERT INTO `tbl_leave_record` (`rowid`, `empid`, `date`, `leave_type`, `descripition`, `status`, `stat`) VALUES (NULL, '{$uid}', '{$date}', '{$leavetype}', '{$description}', '{$status}', '{$stat}')";
            if ($conn->query($sql) === TRUE) {
                echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=success"/>';
            }
            else {
                echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=failed"/>';
            }
        }
        else {
            echo '<meta http-equiv="refresh" content="0; URL=../leave.php?status=nosick"/>';
        }
    }
    else {
        echo '<meta http-equiv="refresh" content="0; URL=../leave.php#"/>';
    }
}
else {
    echo '<meta http-equiv="refresh" content="0; URL=../leave?status=sessionrunning"/>';
}    
?>