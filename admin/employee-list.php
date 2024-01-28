<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    require_once "../config.php";
    $sql = mysqli_query($conn, "SELECT * FROM `tbl_employee` ORDER BY `tbl_employee`.`Emp_ID` ASC");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
        $name = $row['Emp_Name'];
        $email = $row['Emp_Email'];
        $type = $row['Emp_Type'];
        $id = $row['Emp_ID'];
    }
?>
<head>
    <title>Employees</title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <?php include_once "common/header.php"; ?>    
    <div class="container-fluid">
        <div class="row">
            <?php include_once "common/sidebar.php"; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Employees</h1>  
                    <form method='GET' action='export.php' enctype='multipart/form-data'>
                        <input type='hidden' name='export' value="emplist">
                        <input type='hidden' name='systitle' value="All Employees">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Export</button>
                    </form>
                </div>
                <?php
                    if(isset($_GET["status"])){
                        if($_GET['status'] == 'delsuccess'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Employee deleted successfully.</div>';
                        }
                        elseif($_GET['status'] == 'delerror'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Failed to delete employee. Try again.</div>';
                        }
                        elseif($_GET['status'] == 'unconfirmed'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Invalid employee delete confirmation. Try again.</div>';
                        }
                        else{
                            echo '';
                        }
                    }
                    echo "<div class='table-responsive-xxl'>
                        <table class='table table-striped table-sm table-hover' id='dataTable'>
                            <thead>
                                <tr>
                                    <th scope='col'>#</th>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col'>Type</th>
                                </tr>
                            </thead>
                            <tbody>";
                            $sql = mysqli_query($conn, "SELECT * FROM `tbl_employee` ORDER BY `tbl_employee`.`Emp_ID` ASC");
                                while($row = mysqli_fetch_array($sql)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Emp_ID'] . "</td>";
                                        echo "<td>" . $row['Emp_Name'] . "</td>";
                                        echo "<td>" . $row['Emp_Email'] . "</td>";
                                        echo "<td>" . $row['Emp_Type'] . "</td>";
                                        echo "<td>
                                            <form method='GET' action='employee-data.php' enctype='multipart/form-data'>
                                                <input type='hidden' name='id' value=".$row['Emp_ID'].">
                                                <button type='submit' class='btn btn-primary'><span data-feather='eye'></span>View</button>
                                            </form>
                                        </td>";
                                    echo "</tr>";
                                }
                            echo "</tbody>
                        </table>
                    </div>";
                ?>
            </main>
        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>
