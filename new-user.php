<!doctype html>
<?php
    session_start();
    require_once "config.php";
	if(!isset($_SESSION['uid'])){
		header("location: login.php");
	}
	$uid = $_SESSION['uid'];
?>
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
        .form header{
            letter-spacing: 0.1em;
            word-spacing: 0em;
        }
        p{
            border-bottom: 1px solid #e6e6e6;
            text-align: left;
            padding-bottom: 1%;
            padding-top: 6%;
            margin: 10px 0;
            font-size: 17px;
            border-top: 0px;
            font-weight: 600;
            word-spacing: 0px;
        }
    </style>
</head>
<body>

<div class="wrapper login">
	<section class="form">
		<header>Welcome to Colma HR</header>
        <div class="link">We need to setup some security settings before start working.</div>
        <p>Setup Security Questions</p>
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
		<form method="POST" action="php/new-user.php" enctype="multipart/form-data" >
            <div class="field input">
					<label>Security Question 1</label>
					<select name="sq1"  class="select" required>
						<option value="What city were you born in?" class="select">What city were you born in?</option>
						<option value="What is your oldest sibling’s middle name?" class="select">What is your oldest sibling’s middle name?</option>
						<option value="What was the first concert you attended?" class="select">What was the first concert you attended?</option>
					</select>	
				</div>
				<div class="field input">
					<label>Answer for Security Question 1</label>
					<input type="text" name="sa1" placeholder="Answer for Security Question 1" required>
				</div>
				<br>
                <div class="field input">
					<label>Security Question 2</label>
					<select name="sq2"  class="select" required>
						<option value="What high school did you attend?" class="select">What high school did you attend?</option>
						<option value="What was the make of your first car?" class="select">What was the make of your first car?</option>
						<option value="java" class="What was your favorite food as a child?">What was your favorite food as a child?</option>
					</select>
				</div>
                <div class="field input">
					<label>Answer for Security Question 2</label>
					<input type="text" name="sa2" placeholder="Answer for Security Question 2" required>
				</div>
				<br>
                <div class="field input">
					<label>Security Question 3</label>
					<select name="sq3"  class="select" required>
						<option value="What is your mother's maiden name?" class="select">What is your mother's maiden name?</option>
						<option value="What was your favorite food as a child?" class="select">What was your favorite food as a child?</option>
						<option value="Where did you meet your spouse?" class="select">Where did you meet your spouse?</option>
					</select>
				</div>
                <div class="field input">
					<label>Answer for Security Question 3</label>
					<input type="text" name="sa3" placeholder="Answer for Security Question 3" required>
				</div>
				*Make sure to note down and keep these questions and answers for your future use.
                <br><br>
                <p>Setup New Password</p>
                <div class="field input">
					<label>Password</label>
					<input type="password" name="password" placeholder="Password" required>
				</div>
                <div class="field input">
					<label>Re-enter Password</label>
					<input type="password" name="passwordre" placeholder="Password" required>
				</div>
                <br>
                <input type='hidden' id='uid' name='uid' value= "<?php $uid?>">
			    <input type="submit" class="button" name="Submit" value="Submit">
            </div>    
		</form>
	</section>
</div>
</body>
</html>

