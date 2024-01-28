<?php
session_start();
require_once "config.php";
include 'TimezoneMapper.php';
$uid = $_SESSION['uid'];
$lat  = $_POST['lat'];
$long = $_POST['long'];
$loc = $_POST['loc'];
$function = $_POST['func'];
$mapping = ['lat' => $lat, 'lng' => $long];
$timezone = TimezoneMapper::latLngToTimezoneString($mapping['lat'], $mapping['lng']);
date_default_timezone_set($timezone);
$date = "".date("Y-m-d");
$time = "".date("H:i:s");

$sql = "SELECT rowID, in_date, in_time, out_date, out_time, stat_in, stat_out FROM `tbl_attendance` WHERE Emp_ID = '$uid' ORDER BY `tbl_attendance`.`rowID` DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$rowid = $row["rowID"];
		$stat1 = $row["stat_in"];
		$stat2 = $row["stat_out"];
		$indate = $row["in_date"];
		$intime = $row["in_time"];
	}
}
else {
	$s1 = 1;
	$s2 = 0;
	$sql2 = "INSERT INTO tbl_attendance (Emp_ID, in_date, in_time, in_location, stat_in, stat_out) VALUES ('$uid','$date','$time','$loc','$s1','$s2')";
	if ($conn->query($sql2) === TRUE) {
		$sql3 = mysqli_query($conn, "UPDATE tbl_emp_status SET status = 'Online' WHERE empid = '$uid'");
		setcookie("success-start", "1", time() + 5, "/");
		//echo '<meta http-equiv="refresh" content="0; URL=index.php" />';
	}
	else {
		setcookie("error-start", "1", time() + 5, "/");
		//echo '<meta http-equiv="refresh" content="0; URL=index.php" />';
	}
}
if($function == start){
	if ($stat1 == 1 && $stat2 == 1){
		//echo("Start Working");
		$s1 = 1;
		$s2 = 0;
		$sql2 = "INSERT INTO tbl_attendance (Emp_ID, in_date, in_time, in_location, stat_in, stat_out) VALUES ('$uid','$date','$time','$loc','$s1','$s2')";
		
		if ($conn->query($sql2) === TRUE) {
			$sql3 = mysqli_query($conn, "UPDATE tbl_emp_status SET status = 'Online' WHERE empid = '$uid'");
			setcookie("success-start", "1", time() + 5, "/");
			//echo '<meta http-equiv="refresh" content="0; URL=index.php" />';

			
		}
		else {
			setcookie("error-start", "1", time() + 5, "/");
			//echo '<meta http-equiv="refresh" content="0; URL=index.php" />';
		}
	}
}
elseif($function == end){
	if ($stat1 == 1 && $stat2 == 0){
		$s1 = 1;
		$s2 = 1;
		$start = strtotime($indate . $intime); 
		$end = strtotime($date . $time); 
		$totaltime = ($end - $start)  ;
		$hours = intval($totaltime / 3600);   
		$seconds_remain = ($totaltime - ($hours * 3600)); 
		$minutes = intval($seconds_remain / 60);   
		$seconds = ($seconds_remain - ($minutes * 60));
		$otstat = 1;
		if($seconds >= 0){
			if($minutes >= 0){
				if($hours > 8){
					$overtime = $hours.":".$minutes.":".$seconds;
					$sql2 = "UPDATE tbl_attendance SET out_date = '$date', out_time = '$time', out_location = '$loc', stat_out = '$s2', ot_time = '$overtime', ot_stat = '$otstat' WHERE rowid = '$rowid'";
				}
				else{
					$sql2 = "UPDATE tbl_attendance SET out_date = '$date', out_time = '$time', out_location = '$loc', stat_out = '$s2' WHERE rowid = '$rowid'";
				}
			}
		}
		if ($conn->query($sql2) === TRUE) {
			$sql3 = mysqli_query($conn, "UPDATE tbl_emp_status SET status = 'Offline' WHERE empid = '$uid'");
			setcookie("success-end", "1", time() + 5, "/");	
			//echo '<meta http-equiv="refresh" content="0; URL=index.php" />';
		}
		else {
			setcookie("error-end", "1", time() + 5, "/");
			//echo '<meta http-equiv="refresh" content="0; URL=index.php" />';
		}
	}
}
?>