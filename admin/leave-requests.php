<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    require_once "../config.php";  
?>
<head>
    <title>Leave Requests</title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <?php include_once "common/header.php"; ?>    
    <div class="container-fluid">
        <div class="row">
        <?php include_once "common/sidebar.php"; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Leave Requests</h1>    
                </div>
                <?php 
                    if(isset($_GET["status"])){
                        if($_GET['status'] == 'approved'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Leave request approved.</div>';
                        }
                        elseif($_GET['status'] == 'del'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Leave request declined.</div>';
                        }
                    }
                    else{
                        echo "";
                    }
                ?>
                <div class='table-responsive-xxl'>
                    <table class='table table-striped table-sm table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>ID</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Date</th>
                                <th scope='col'>Leave Type</th>
                                <th scope='col'>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                       
                        <?php
                            $sql = mysqli_query($conn, "SELECT * FROM `tbl_leave_record` WHERE status ='In Review'");
                            while($row = mysqli_fetch_array($sql)){
                                echo "<form method='POST' action='php/leave-request.php' enctype='multipart/form-data'>";
                                echo "<tr>";
                                $empid = $row['empid'];
                                $sql2 = mysqli_query($conn, "SELECT Emp_Name FROM `tbl_employee` WHERE Emp_ID = $empid");
                                $row2 = mysqli_fetch_array($sql2);
                                    echo "<td>" . $row['empid'] . "</td>";
                                    echo "<td>" . $row2['Emp_Name'] . "</td>";
                                    echo "<td>" . $row['date'] . "</td>";
                                    echo "<td>" . $row['leave_type'] . "</td>";
                                    echo "<td>" . $row['descripition'] . "</td>";
                                    echo "<td>
                                        <input type='hidden' name='rowid' value=".$row['rowid'].">
                                        <button type='submit' class='btn btn-success' name='Accept' value='Accept'>Approve</button>
                                        <button type='submit' class='btn btn-danger' name='Decline' value='Decline'>Decline</button>
                                    </td>";    
                                echo "</tr>";
                                echo "</form>";
                            }
                        echo "</tbody>";
                        ?>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>