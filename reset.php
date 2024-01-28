<?php
session_start();
require_once "config.php";
if(!isset($_SESSION['forgot']) && !isset($_SESSION['reset'])){
	header("location: login.php");
}
$uid = $_SESSION['forgot'];
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>COLMA HR | Reset Password</title>
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
                if(isset($_GET["status"]) == 'unmatching') {
                    echo '<div class="error">Unmatching Fields.</div>';
                }
                else{
                    echo '';
                }
            ?>
            <form method="POST" action="php/reset-password.php" enctype="multipart/form-data" >
                <div class="field input">
                    <label>Enter New Password</label>
                    <input type="password" name="new-password" placeholder="" required>
                </div>
                <div class="field input">
                    <label>Re-enter New Password</label>
                    <input type="password" name="new-re-password" placeholder="" required>
                </div>
                <input type="submit" class="button" name="reset" value="Reset Password">
            </form>  
        </section>
    </div>
</body>
</html>