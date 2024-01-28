<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    require_once "../config.php";
    $sql = mysqli_query($conn, "SELECT * FROM `tbl_signuprequest`");
?>
<head>
    <title>Signup Requests</title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <?php include_once "common/header.php"; ?>    
    <div class="container-fluid">
        <div class="row">
        <?php include_once "common/sidebar.php"; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Requests</h1>    
                </div>
                <?php
                    if(isset($_GET["status"]) == "success") {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Employee added successfully.</div>';
                    }
                    elseif (isset($_GET["status"]) == "repeat"){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Employee Already Exist.</div>';
                    }
                    elseif (isset($_GET["status"]) == "error"){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Failed to add new employee. Refresh and try again.</div>';
                    }
                    else{
                        echo "";
                    }
                ?>
                <div class='table-responsive-xxl'>
                    <table class='table table-striped table-sm table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>Name</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>Select Type</th>
                                <th scope='col'>Review</th>
                            </tr>
                        </thead>
                        <tbody>
                       
                        <?php
                            while($row = mysqli_fetch_array($sql)){
                                echo "<form method='POST' action='php/useraccept.php' enctype='multipart/form-data'>";
                                echo "<tr>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    $sql2 = mysqli_query($conn, "SELECT * FROM tbl_emp_types");
                                        echo "<td>
                                            <select class='form-select' id='type' name='type' required>
                                                <option></option>";
                                                while($row2 = mysqli_fetch_array($sql2)){
                                                    echo "<option>" . $row2['name'] . "</option>";
                                                }
                                            echo "</select>
                                        </td>";
                                    echo "<td>
                                        <input type='hidden' name='request_id' value= ".$row['request_id'].">
                                        <button type='submit' class='btn btn-success' name='Accept' value='Accept'><span data-feather='check'></span>Accept</button>
                                        <button type='submit' class='btn btn-danger' name='Delete' value='Delete'><span data-feather='trash-2'></span>Decline</button>
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