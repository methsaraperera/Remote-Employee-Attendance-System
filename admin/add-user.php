<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    $uid = $_SESSION['adminid'];
    require_once "../config.php";
    
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
                    <h1 class="h2">Add Employee</h1>   
                    <form method='GET' action='export.php' enctype='multipart/form-data'>
                        <input type='hidden' name='export' value="admins">
                        <input type='hidden' name='systitle' value="Admins">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Export</button>
                    </form>
                </div>
                <?php 
                    if(isset($_GET["status"])){
                        if($_GET['status'] == 'success'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Employee added successfully.</div>';
                        }
                        elseif($_GET['status'] == 'repeat'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error. Employee with this email address already exist.</div>';
                        }
                    }
                    else{
                        echo "";
                    }
                ?>
                <?php
                    echo "<div class='table-responsive-xxl'>
                        <p class='lead'>Add new employee</p>
                        <table class=' table-sm'>
                            <thead>
                                <tr>
                                    <th scope='col'>Employee Name</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col'>Password</th>
                                    <th scope='col'>Type</th>
                                </tr>
                            </thead>
                            <tbody>";
                                echo "<form method='POST' action='php/add-employee.php' enctype='multipart/form-data'>";
                                    echo "<tr>";
                                        echo "<td><input type='text' class='form-control' placeholder='' id='empname' name='empname' autocomplete='off' required></td>";
                                        echo "<td><input type='email' class='form-control' placeholder='' id='empemail' name='empemail' autocomplete='off' required></td>";
                                        echo "<td><input type='password' class='form-control' placeholder='' id='emppassword' name='emppassword' autocomplete='off' required></td>";
                                        $sql2 = mysqli_query($conn, "SELECT * FROM tbl_emp_types");
                                        echo "<td>
                                            <select class='form-select' id='emptype' name='emptype' required>
                                                <option></option>";
                                                while($row2 = mysqli_fetch_array($sql2)){
                                                    echo "<option>" . $row2['name'] . "</option>";
                                                }
                                            echo "</select>
                                        </td>";
                                        echo "<td><button type='submit' class='btn btn-primary btn-lg' name='add' value='add'><span data-feather='plus-square'></span>Add</button></td>";    
                                    echo "</tr>";
                                echo "</form>";
                            echo "</tbody>
                        </table>
                      ";
                        
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
