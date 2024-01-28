<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    $uid = $_SESSION['adminid'];
    require_once "../config.php";
    $sql = mysqli_query($conn, "SELECT * FROM `tbl_admin` WHERE Status = '$uid'");
    if(mysqli_num_rows($sql) > 0){
        $stat = "1";
    }
    else{
        $stat = "0";
    }
?>
<head>
    <title>Users</title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <script>
        function downloadPDFWithBrowserPrint() {
            window.print();
        }
        document.querySelector("table").addEventListener('click', downloadPDFWithBrowserPrint);
    </script>
    <?php include_once "common/header.php"; ?>    
    <div class="container-fluid">
        <div class="row">
        <?php include_once "common/sidebar.php"; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Users</h1>   
                    <form method='GET' action='export.php' enctype='multipart/form-data'>
                        <input type='hidden' name='export' value="admins">
                        <input type='hidden' name='systitle' value="Admins">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Export</button>
                    </form>
                </div>
                <?php 
                    if(isset($_GET["status"])){
                        if($_GET['status'] == 'success'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Added new admin.</div>';
                        }
                        elseif($_GET['status'] == 'repeat'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error. Employee with this email address already exist.</div>';
                        }
                        elseif($_GET['status'] == 'delsuccess'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Admin deleted successfully.</div>';
                        }
                        elseif($_GET['status'] == 'delerror'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Failed to delete admin. Try again.</div>';
                        }
                        elseif($_GET['status'] == 'delerroruser'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Admin cannot be deleted.</div>';
                        }
                    }
                    else{
                        echo "";
                    }
                ?>
                <?php
                    echo "<div class='table-responsive-xxl'>
                        <p class='lead'>Add new admin user</p>
                        <table class=' table-sm'>
                            <thead>
                                <tr>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col'>Password</th>
                                </tr>
                            </thead>
                            <tbody>";
                                echo "<form method='POST' action='php/add-admin.php' enctype='multipart/form-data'>";
                                    echo "<tr>";
                                        echo "<td><input type='text' class='form-control' placeholder='' id='name' name='name' autocomplete='off' required></td>";
                                        echo "<td><input type='email' class='form-control' placeholder='' id='email' name='email' autocomplete='off' required></td>";
                                        echo "<td><input type='password' class='form-control' placeholder='' id='password' name='password' autocomplete='off' required></td>";
                                        echo "<td><button type='submit' class='btn btn-primary btn-lg' name='add' value='add'><span data-feather='plus-square'></span>Add</button></td>";    
                                    echo "</tr>";
                                echo "</form>";
                            echo "</tbody>
                        </table>
                        <hr class='my-4'>
                        <br>
                        <p class='lead'>Available Admins</p>
                        <table class='table table-sm' id='dataTable'>
                            <thead>
                                <tr>
                                    <th scope='col'># </th>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col'></th>
                                </tr>
                            </thead>
                            <tbody>";
                                $sql = mysqli_query($conn, "SELECT * FROM `tbl_admin` ORDER BY `Admin_ID` ASC");
                                while($row = mysqli_fetch_array($sql)){
                                    echo "<form method='POST' action='php/delete-admin.php' enctype='multipart/form-data'>";
                                        echo "<tr>";
                                            echo "<td scope='col'>".$row['Admin_ID']."</td>";
                                            echo "<td scope='col'>".$row['Admin_Name']."</td>";
                                            echo "<td scope='col'>".$row['Admin_Email']."</td>";
                                            echo "<input type='hidden' id='id' name='id' value=".$row['Admin_ID'].">";
                                            echo "<td scope='col'> 
                                            <button type='submit' class='btn btn-danger' name='delete' value='delete'><span data-feather='trash-2'></span>Delete</button>    
                                            </td>";    
                                        echo "</tr>";
                                    echo "</form>";
                                }
                            echo "</tbody>
                        </table>";

                        if(isset($_GET["status"])){
                            echo "<hr class='my-4'>";
                            if($_GET['status'] == 'success-reset'){
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Reset Successful.</div>';
                            }
                            elseif($_GET['status'] == 'unmatch-reset'){
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error. Unmatching Fields.</div>';
                            }
                            elseif($_GET['status'] == 'del-reset'){
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Rejected reset request.</div>';
                            }
                            elseif($_GET['status'] == 'fields-reset'){
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error. Make sure to fill both New Password and Re-enter new password.</div>';
                            }
                        }
                        else{
                            echo "";
                        }
                        if($stat == 1){
                            echo "<hr class='my-4'>
                            <p class='lead'>Admin Password Reset Request</p>
                            <table class='table-sm'>
                                <thead>
                                    <tr>
                                        <th scope='col'>Name</th>
                                        <th scope='col'>New Password</th>
                                        <th scope='col'>Re-enter new password</th>
                                        <th scope='col'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>";
                                    $sql3 = mysqli_query($conn, "SELECT * FROM `tbl_admin` WHERE Status = '$uid'");
                                    while($row3 = mysqli_fetch_array($sql3)){
                                        echo "<form method='POST' action='php/forgot-password.php' enctype='multipart/form-data'>";
                                            echo "<tr>";
                                                echo "<td>".$row3['Admin_Name'] ." &nbsp&nbsp </td>";
                                                echo "<input type='hidden' id='email' name='email' value=".$row3['Admin_Email'].">";
                                                echo "<td><input type='password' class='form-control' placeholder='' id='password' name='password'></td>";
                                                echo "<td><input type='password' class='form-control' placeholder='' id='passwordre' name='passwordre'></td>";
                                                echo "<td><button type='submit' class='btn btn-success' name='reset-ok' value='reset-ok'>Reset</button></td>";    
                                                echo "<td><button type='submit' class='btn btn-danger' name='reset-no' value='reset-no'>Decline</button></td>";  
                                            echo "</tr>";
                                        echo "</form>";
                                    }
                                echo "</tbody>
                            </table>";
                        }  
                    echo "</div> <br>";
                ?>    
            </main>
        </div>
    </div>
    <script src="tableExport/tableExport.js"></script>
    <script type="text/javascript" src="tableExport/jquery.base64.js"></script>
    <script src="js/export.js"></script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>
