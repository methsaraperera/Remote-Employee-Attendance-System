<?php
session_start();
require_once "config.php";
if(!isset($_SESSION['uid'])){
	header("location: login.php");
}
$uid = $_SESSION['uid'];
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>COLMA HR | Change Password</title>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script language="javascript" type="text/javascript" src="location.js"></script>
<link rel="stylesheet" href="style.css">
<style>
	body{
		display: flex;
		align-items: center;
		justify-content: center;
		min-height: 80vh;
		background: #f7f7f7;
		padding: 10px 10px 10px 10px;
	}
	.wrapper{
		background: #fff;
		max-width: 500px;
		height: 100%;
		border-radius: 16px;
	}
</style>
</head>

<body>
<div class="wrapper login">
	<section class="form">	
		<header>COLMA HR</header>
		<p>Change Password</p>
        <?php 
			if(isset($_GET["status"])) {
				if($_GET['status'] == 'pass-changed'){
                    echo '<div class="success">Password Changed Successfully.</div>';
                }
				elseif(isset($_GET["status"]) == 'pass-error'){
					echo '<div class="error">Unmatching fields.</div>';
				}
				elseif(isset($_GET["status"]) == 'expass'){
					echo '<div class="error">Incorrect existing password.</div>';
				}
			}
        ?>
        <form method="POST" action="php/change-password.php" enctype="multipart/form-data" >
			<div class="field input">
				<label>Enter Current Password</label>
				<input type="password" name="old-password" placeholder="" required>
			</div>
			<div class="field input">
				<label>Enter New Password</label>
				<input type="password" name="new-password" placeholder="" required>
			</div>
			<div class="field input">
				<label>Re-enter New Password</label>
				<input type="password" name="new-re-password" placeholder="" required>
			</div>
			<input type="hidden" name="id" value= "<?php echo $uid;?>">
			<input type="submit" class="button" name="change" value="Change Password">
		</form>
        <div class="link">Get back to <a href="index.php">Dashboard</a></div>
	</section>    
</div>
</body>
</html>