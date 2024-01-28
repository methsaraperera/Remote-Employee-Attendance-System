<?php
session_start();
require_once "config.php";
if(!isset($_SESSION['forgot'])){
	header("location: login.php");
}
$uid = $_SESSION['forgot'];
$sql = mysqli_query($conn, "SELECT sq1, sq2, sq3 FROM tbl_employee WHERE Emp_ID= '{$uid}'");
$row = mysqli_fetch_assoc($sql);
$sq1 = $row['sq1'];
$sq2 = $row['sq2'];
$sq3 = $row['sq3'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>COLMA HR | Forgot Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
		box-shadow: 0 0 128px 0 rgba(0,0,0,0.1),
			0 32px 64px -48px rgba(0,0,0,0.5);
	}
</style>
</head>
<body>
    <div class="wrapper login">	
        <section class="form">
            <header>Forgot Password</header>
            <?php
                if(isset($_GET["status"]) == 'invalid') {
                    echo '<div class="error">Invalid Answers.</div>';
                }
                else{
                    echo '';
                }
            ?>
            <form method="POST" action="php/security-checkup.php" enctype="multipart/form-data">
                <div class="field input">
                    <label><?php echo $sq1; ?></label>
                    <input type="text" name="sa1" placeholder="Answer" required>
                </div>  
                <div class="field input">
                    <label><?php echo $sq2; ?></label>
                    <input type="text" name="sa2" placeholder="Answer" required>
                </div> 
                <div class="field input">
                    <label><?php echo $sq3; ?></label>
                    <input type="text" name="sa3" placeholder="Answer" required>
                </div> 
                <input type="submit" class="button" name="submit" value="Submit">
            </form>       
        </section>
    </div>
</body>
</html>