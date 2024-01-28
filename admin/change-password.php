<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
require_once "../config.php";
$uid = $_SESSION['adminid'];
?>
<head>
    <title>Change Password</title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <?php include_once "common/header.php"; ?>    
    <div class="container-fluid">
        <div class="row">
        <?php include_once "common/sidebar.php";?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Change Password</h1>   
                </div>
                <div>
                    <div class="row g-5">
                    <div class="col-md-5 col-lg-4 order-md-last">
                        <?php 
                            if(isset($_GET["ps"]) == 'pass-changed') {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Password Changed.</div>';
                            }
                            elseif(isset($_GET["err"]) == 'pass-error'){
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Unmatching fields.</div>';
                            }
                            else{
                                echo "";
                            }
                        ?>
                        <form method="POST" action="php/admin-change-password.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" value= "<?php echo $uid;?>">
                            <label for="pass-change" class="form-label">Enter Old Password</label>
                            <input type="password" class="form-control" id="pass-old" name="pass-old" placeholder="">
                            <label for="pass-change" class="form-label">Enter New Password</label>
                            <input type="password" class="form-control" id="pass-change" name="pass-change" placeholder="">
                            <label for="pass-change-re" class="form-label">Re-enter New Password</label>
                            <input type="password" class="form-control" id="pass-change-re" name="pass-change-re" placeholder="">
                            <br>
                            <button type="submit" class="btn btn-secondary" name='Change' value='Change'>Change Password</button>
                        </form>
                    </div>
                </div>
            </main> 
        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>