<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>COLMA HR | Login</title>
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
		<header>Login</header>
		<?php 
			if(isset($_GET["status"])){ 
				if($_GET['status'] == 'inemail'){
                    echo '<div class="error">User not found.</div>';
                }
				elseif($_GET['status'] == 'inpassword'){
                    echo '<div class="error">Password Invalid.</div>';
                }
                elseif($_GET['status'] == 'reset-success'){
                    echo '<div class="success">Password reset successfull.</div>';
                }
                elseif($_GET['status'] == 'reset-failrd'){
                    echo '<div class="error">Password reset failed.</div>';
                }
            }
            else{
                echo "";
            }
        ?>
		<form method="POST" action="php/login.php" enctype="multipart/form-data" >
			<div class="field input">
				<label>Email Address</label>
				<input type="text" name="email" placeholder="Enter Your Email Address" required>
			</div>
			<div class="field input">
				<label>Password</label>
				<input type="password" name="password" placeholder="Password" required>
			</div>
			<input type="submit" class="button" name="Login" value="Login">
		</form>
		<div class="link"><a href="forgot-password.php">Forgot Password</a></div>
		<div class="link">Not Signed Up Yet? <a href="register.php">Sign Up Now</a></div>	
	</section>
</div>
</body>
</html>