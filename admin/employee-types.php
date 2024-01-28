<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    require_once "../config.php";
    $sql = mysqli_query($conn, "SELECT * FROM `tbl_emp_types` ORDER BY `tbl_emp_types`.`typeid` ASC");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
        $id = $row['typeid'];
        $name = $row['name'];
    }
?>
<head>
    <title>Types</title>
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
                    <h1 class="h2">Types</h1>   
                    <form method='GET' action='export.php' enctype='multipart/form-data'>
                        <input type='hidden' name='export' value="types">
                        <input type='hidden' name='systitle' value="Types">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Export</button>
                    </form>
                </div>
                <?php 
                    if(isset($_GET["status"])){
                        if($_GET['status'] == 'success'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Added new emlployee type.</div>';
                        }
                        elseif($_GET['status'] == 'namerepeat'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error. Use unique unuesd name when creating a new employee type.</div>';
                        }
                        elseif($_GET['status'] == 'updated'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Employee type updated successfully.</div>';
                        }
                        elseif($_GET['status'] == 'error'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Failed to update employee type. Try again.</div>';
                        }
                        elseif($_GET['status'] == 'deleted'){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Employee type deleted.</div>';
                        }
                        elseif($_GET['status'] == 'filled'){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Assign the employees with this employees type to another employee type.</div>';
                        }
                    }
                    else{
                        echo "";
                    }

                    echo "<div class='table-responsive-xxl'>
                    <p class='lead'>Add new employee type</p>
                    <p class='text-secondary'>Always make sure to use unique unused name when creating a new employee type.</p>
                    <table class=' table-sm'>
                            <thead>
                                <tr>
                                    <th scope='col'>Type Name</th>
                                    <th scope='col'>Annual Leaves</th>
                                    <th scope='col'>Casual Leaves</th>
                                    <th scope='col'>Sick Leaves</th>
                                    <th scope='col'>Max OT Hours - Day</th>
                                    <th scope='col'></th>
                                </tr>
                            </thead>
                            <tbody>";
                                echo "<form method='POST' action='php/add-emptype.php' enctype='multipart/form-data'>";
                                    echo "<tr>";
                                        echo "<td><input type='text' class='form-control' placeholder='' id='name' name='name' required></td>";
                                        echo "<td><input type='text' class='form-control' placeholder='' id='annual' name='annual' required></td>";
                                        echo "<td><input type='text' class='form-control' placeholder='' id='casual' name='casual' required></td>";
                                        echo "<td><input type='text' class='form-control' placeholder='' id='sick' name='sick' required></td>";
                                        echo "<td><input type='text' class='form-control' placeholder='' id='maxot' name='maxot' required></td>";
                                        echo "<td><button type='submit' class='btn btn-primary btn-lg' name='add' value='add'><span data-feather='plus-square'></span>Add</button></td>";    
                                    echo "</tr>";
                                echo "</form>";
                            echo "</tbody>
                        </table>
                        <hr class='my-4'>
                        <br>
                        <p class='lead'>Available Employee Types</p>
                        <table class='table table-bordered table-sm' id='dataTable'>
                            <thead>
                                <tr class='d-flex'>
                                    <!--<th scope='col'># </th>-->
                                    <th class='col-2'>Employee Type</th>
                                    <th class='col-2'>Annual Leaves</th>
                                    <th class='col-2'>Casual Leaves</th>
                                    <th class='col-2'>Sick Leaves</th>
                                    <th class='col-2'>Max OT Hours - Day</th>
                                    <th class='col-1'style='width: 12.499999995%; flex: 0 0 12.499%;max-width: 12.499%;'></th>
                                </tr>
                            </thead>
                            <tbody>";
                                $sql = mysqli_query($conn, "SELECT * FROM `tbl_emp_types` ORDER BY `name` ASC");
                                while($row = mysqli_fetch_array($sql)){
                                    echo "<form method='POST' action='php/edit-emptypes.php' enctype='multipart/form-data'>";
                                        echo "<tr class='d-flex'>";
                                            //echo "<td scope='col'>".$row['typeid']."</td>";
                                            echo "<td class='col-2'>".$row['name']."</td>";
                                            echo "<td class='col-2'><input type='text' class='form-control' placeholder='' id='annual' name='annual' value=".$row['annual']."><p hidden>".$row['annual']."</p></td>";
                                            echo "<input type='hidden' id='typeid' name='typeid' value= ".$row['annual'].">";
                                            echo "<td class='col-2'><input type='text' class='form-control' placeholder='' id='casual' name='casual' value=".$row['casual']."><p hidden>".$row['annual']."</p></td>";
                                            echo "<td class='col-2'><input type='text' class='form-control' placeholder='' id='sick' name='sick' value=".$row['sick']."><p hidden>".$row['annual']."</p></td>";
                                            echo "<td class='col-2'><input type='text' class='form-control' placeholder='' id='max' name='max' value=".$row['max_ot_hours']."><p hidden>".$row['annual']."</p></td>";
                                            echo "<td class='col-1'style='width: 12.499999995%; flex: 0 0 12.499%;max-width: 12.499%;'> 
                                                <input type='hidden' id='typeid' name='typeid' value= ".$row['typeid'].">
                                                <input type='hidden' id='typename' name='typename' value= ".$row['name'].">
                                                <button type='submit' class='btn btn-success' name='edit' value='edit'><span data-feather='edit'></span>Edit</button>
                                                <button type='submit' class='btn btn-danger' name='delete' value='delete'><span data-feather='trash-2'></span>Delete</button>    
                                            </td>";    
                                        echo "</tr>";
                                    echo "</form>";
                                }
                            echo "</tbody>
                        </table>
                    </div>";
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
