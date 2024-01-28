<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
require_once "../config.php";
if(isset($_POST['delete'])){
    $id = $_POST['id'];    
}
    
?>
<head>
    <title>Warning</title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <?php include_once "common/header.php"; ?>    
    <div class="container-fluid">
        <div class="row">
        <?php include_once "common/sidebar.php";?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Delete Employee</h1>   
                </div>
                <div>
                    <div class="row g-5">
                    <div class="col-md-5  order-md-last">
                    <div class="alert alert-warning" role="alert">Do you really want to delete this employee.<br>This process cannot be undone and this will remove all the employee's data from this system.</div>
                        <form method="POST" action="php/delete-employee.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" value= "<?php echo $id;?>">
                            <label class="form-label">Type "CONFIRM" to delete employee.</label>
                            <input type="text" class="form-control" name="confirm" placeholder="">
                            <br>
                            <button type="submit" class="btn btn-danger" name='delete'>Confirm Delete</button>
                        </form>
                        
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>