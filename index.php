<?php
	session_start();
	require_once "config.php";
	if(!isset($_SESSION['uid'])){
		header("location: login.php");
	}
	$uid = $_SESSION['uid'];

	$new = mysqli_query($conn, "SELECT SQ1, SQ2, SQ3 from `tbl_employee` WHERE Emp_ID = '$uid'");
	if(mysqli_num_rows($new) > 0){
		$newrow = mysqli_fetch_assoc($new);
		if($newrow['SQ1'] == NULL && $newrow['SQ2'] == NULL && $newrow['SQ3'] == NULL){
			header("location: new-user.php");
		}
	}
	$sot_stat = 0;
	$search = mysqli_query($conn, "SELECT rowid, ot_stat from `tbl_attendance` WHERE Emp_ID = '$uid'  ORDER BY `tbl_attendance`.`rowID` DESC LIMIT 1");
	if(mysqli_num_rows($search) > 0){
		$srow = mysqli_fetch_assoc($search);
		$srowid = $srow['rowid'];
		$sot_stat = $srow['ot_stat'];
	}
	$statsearch = mysqli_query($conn, "SELECT status from `tbl_emp_status` WHERE empid = '$uid'");
	$statrow = mysqli_fetch_assoc($statsearch);
	$stat = $statrow['status'];
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>COLMA HR | Dashboard</title>
	<script src="js/jquery-2.2.4.min.js"></script>
	<script language="javascript" type="text/javascript" src="location.js"></script>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper">
		<section class="form">	
			<header>COLMA HR</header>
			<p>WORK - <?php echo $statrow['status'];?></p>
			<div>
				<?php
					if($sot_stat == 1){
						echo "<div class='notice'>Did you worked overtime in your last ended working session. &nbsp
							<div>
								<form method='POST' action='php/overtime.php' enctype='multipart/form-data'>
									<input type='hidden' id='rowid' name='rowid' value= ".$srowid.">
									<button class='button-small' name='yes' value='yes'>Yes</button>
									<button class='button-small-no' name='no' value='no'>No</button>
								</form>	
							</div>	
						</div>";
					}
					else{}
				?>
				<?php 
					if(isset($_GET["status"]) == 'repeat') {
						echo '<div class="error">REPEAT</div>';
					}
					elseif(isset($_GET["err"]) == 'pass-error'){
						echo '<div class="error">Unmatching fields.</div>';
					}
					else{
						echo "";
					}
				?>
				<?php
					if(!isset($_COOKIE["success-start"])) {
						echo "";
					}
					else {
						echo '<div class="success">Working Started.</div>';
					}
					if(!isset($_COOKIE["error-start"])) {
						echo "";
					}
					else {
						echo '<div class="error">Failed to start working session. Refresh and try again.</div>';
					}
					if(!isset($_COOKIE["success-end"])) {
						echo "";
					}
					else {
					echo '<div class="success">Working Ended.</div>';
					}
					if(!isset($_COOKIE["error-end"])) {
					echo "";
					}
					else {
					echo '<div class="error">Failed to end work session. Refresh and try again.</div>';
				}
				?>
			</div>
			<button class="button" onClick="getLocationstart()" >Start Working</button>
			<div id="output"></div>
			<script>
					var x = document.getElementById('output');
					function getLocationstart(){
					if (navigator.geolocation){
						navigator.geolocation.getCurrentPosition(showPositionStart);	
					}
					else{
					}
				}
			</script>
			<button class="button" onClick="getLocationend()">End Working</button>			
			<script>
					var x = document.getElementById('output');
					function getLocationend(){
					if (navigator.geolocation){
						navigator.geolocation.getCurrentPosition(showPositionEnd);	
					}
					else{
					}
				}
			</script>
			<?php 
				$currYear = date('Y');
				$startYear = $currYear . "-01-01";
				$endYear = $currYear . "-12-31";
				$sql1 = mysqli_query($conn, "SELECT Emp_Type FROM tbl_employee WHERE Emp_ID = '$uid'");
				if(mysqli_num_rows($sql1) > 0){
					$row1 = mysqli_fetch_assoc($sql1);{
						$type = $row1["Emp_Type"];
						$sql2 = mysqli_query($conn, "SELECT * FROM tbl_emp_types WHERE name = '$type'");
						if(mysqli_num_rows($sql2) > 0){
							$row2 = mysqli_fetch_assoc($sql2);{
								$typeid = $row2["typeid"];
								$sql3 = mysqli_query($conn, "SELECT * FROM tbl_leave_type WHERE emp_type_id = '$typeid'");
								if(mysqli_num_rows($sql3) > 0){
									$row3 = mysqli_fetch_assoc($sql3);{
										$tl1 = $row3["annual"];
										$tl2 = $row3["casual"];
										$tl3 = $row3["sick"];
										$sqlannual = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$uid' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'annual'");
										$rowannual = mysqli_fetch_assoc($sqlannual);
										$annual = $rowannual['COUNT(*)'];
										$sqlcasual = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$uid' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'casual'");
										$rowcasual = mysqli_fetch_assoc($sqlcasual);
										$casual = $rowcasual['COUNT(*)'];
										$sqlsick = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$uid' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'sick'");
										$rowsick = mysqli_fetch_assoc($sqlsick);
										$sick = $rowsick['COUNT(*)'];
										$annualsub = $tl1 - $annual;
										$casualsub = $tl2 - $casual;
										$sicksub = $tl3 - $sick;
									}
								}
							}
						}
					}
				}
			?>
			<p>LEAVE MANAGEMENT</p>
			<section class="home-section">
				<div class="home-content">
					<div class="overview-boxes">
						<div class="box">
							<div class="right-side">
								<div class="box-topic">Annual</div>
								<div class="number"><?php echo ($annualsub);?></div>
							</div>
						</div>
						<div class="box">
							<div class="right-side">
								<div class="box-topic">Casual</div>
								<div class="number"><?php echo ($casualsub);?></div>
							</div>
						</div>
						<div class="box">
							<div class="right-side">
								<div class="box-topic">Sick</div>
								<div class="number"><?php echo ($sicksub);?></div>
							</div>
						</div>
					</div>
					<br>
					<button class="button" onclick="location.href = 'leave.php';">Take Leave</button>
				</div>	
			</section>
			<p></p>
			<div class="link">			  
				<a href="change-password.php" style="font-weight: bold">Change Password</a>&nbsp; &nbsp; | &nbsp; &nbsp;
				Click here to <a href="php/logout.php">Logout</a>
			</div>
		</section>
	</div>
</body>
</html>