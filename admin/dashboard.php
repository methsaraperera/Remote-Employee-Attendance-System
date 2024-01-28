<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    require_once "../config.php";
    $onlinequery = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_emp_status WHERE status = 'Online'");
    $onlineq = mysqli_fetch_assoc($onlinequery);
    $online = $onlineq['COUNT(*)'];
    $offlinequery = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_emp_status WHERE status = 'Offline'");
    $offlineq = mysqli_fetch_assoc($offlinequery);
    $offline = $offlineq['COUNT(*)'];
    $leavequery = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_leave_record WHERE status = 'In Review'");
    $leaveq = mysqli_fetch_assoc($leavequery);
    $leave = $leaveq['COUNT(*)'];
?>

<head>
    <title>Dashboard</title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <?php include_once "common/header.php";?>    
    <div class="container-fluid">
        <div class="row">
        <?php include_once "common/sidebar.php";?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>  
                </div>
                <br>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body h3"><?php echo $online;?> Online</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="status">Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body h3"><?php echo $offline;?> Offline</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="status">Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-secondary text-white mb-4">
                            <div class="card-body h3"><?php echo $leave;?> Leave Requests</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="leave-requests">Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main> 
        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>