<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    date_default_timezone_set('Asia/Colombo');
    $sysdate = "".date("Y-m-d");
    require_once "../config.php";
    $onlinequery = mysqli_query($conn, "SELECT * FROM tbl_emp_status WHERE status = 'Online' ORDER BY empid ASC");
    $offlinequery = mysqli_query($conn, "SELECT * FROM tbl_emp_status WHERE status = 'Offline' ORDER BY empid ASC");
    $leavequery = mysqli_query($conn, "SELECT * FROM tbl_leave_record WHERE date = '$sysdate'AND status='Approved' ORDER BY empid ASC");
?>
<head>
    <title>Status</title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <?php include_once "common/header.php";?>    
    <div class="container-fluid">
        <div class="row">
        <?php include_once "common/sidebar.php";?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Status</h1>  
                </div>
                <br>
                <div class="row">
                    <div class="col-xl-6">
                        <p class="lead">Online</p>
                        <table class='table table-striped table-sm table-hover'>
                            <thead>
                                <tr>
                                    <th scope='col'>ID</th>
                                    <th scope='col'>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($online = mysqli_fetch_array($onlinequery)){
                                        $id = $online['empid'];
                                        echo "<tr>
                                            <td>".$id."</td>
                                            <td>";
                                            $name = mysqli_query($conn, "SELECT Emp_Name FROM tbl_employee WHERE Emp_ID = $id ");
                                            $rowname = mysqli_fetch_assoc($name);
                                            echo $rowname['Emp_Name'];
                                            echo"</td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xl-6">
                        <p class="lead">Offline</p>
                        <table class='table table-striped table-sm table-hover'>
                            <thead>
                                <tr>
                                    <th scope='col'>ID</th>
                                    <th scope='col'>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($offline = mysqli_fetch_array($offlinequery)){
                                        $id = $offline['empid'];
                                        echo "<tr>
                                            <td>".$id."</td>
                                            <td>";
                                            $name = mysqli_query($conn, "SELECT Emp_Name FROM tbl_employee WHERE Emp_ID = $id");
                                            $rowname = mysqli_fetch_assoc($name);
                                            echo $rowname['Emp_Name'];
                                            echo"</td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xl-6">
                        <p class="lead">On Leave - Today</p>
                        <table class='table table-striped table-sm table-hover'>
                            <thead>
                                <tr>
                                    <th scope='col'>ID</th>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($leave = mysqli_fetch_array($leavequery)){
                                        $id = $leave['empid'];
                                        echo "<tr>";
                                        $type = $leave['leave_type'];
                                            echo "<td>".$id."</td>
                                            <td>";
                                            $name = mysqli_query($conn, "SELECT Emp_Name FROM tbl_employee WHERE Emp_ID = $id");
                                            $rowname = mysqli_fetch_assoc($name);
                                            echo $rowname['Emp_Name'];
                                            echo"</td>";
                                            echo "<td>".$type."</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main> 
        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>