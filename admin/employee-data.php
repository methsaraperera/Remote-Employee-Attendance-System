<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    require_once "../config.php";
    $id = $_GET['id'];
    
    $sql = mysqli_query($conn, "SELECT * FROM `tbl_employee` WHERE Emp_ID=".$_GET['id']."");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
        $name = $row['Emp_Name'];
        $email = $row['Emp_Email'];
        $type = $row['Emp_Type'];
        $id = $row['Emp_ID'];
    }
    $sql = mysqli_query($conn, "SELECT * FROM `tbl_emp_status` WHERE empid=".$_GET['id']."");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
        $status = $row['status'];
    }

    $currYear = date('Y');
    $startYear = $currYear . "-01-01";
    $endYear = $currYear . "-12-31";
    $sql1 = mysqli_query($conn, "SELECT Emp_Type FROM tbl_employee WHERE Emp_ID = '$id'");
    if(mysqli_num_rows($sql1) > 0){
        $row1 = mysqli_fetch_assoc($sql1);{
            $type = $row1["Emp_Type"];
            $sql2 = mysqli_query($conn, "SELECT * FROM tbl_emp_types WHERE name = '$type'");
            if(mysqli_num_rows($sql2) > 0){
                $row2 = mysqli_fetch_assoc($sql2);{
                    $typeid = $row2["typeid"];
                    $sql3 = mysqli_query($conn, "SELECT * FROM tbl_leave_type WHERE emp_type_id = '$typeid'");
					if(mysqli_num_rows($sql3) > 0){
						$row3 = mysqli_fetch_assoc($sql3);{
                            $tl1 = $row2["annual"];
                            $tl2 = $row2["casual"];
                            $tl3 = $row2["sick"];
                            $sqlannual = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$id' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'annual'");
                            $rowannual = mysqli_fetch_assoc($sqlannual);
                            $annual = $rowannual['COUNT(*)'];
                            $sqlcasual = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$id' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'casual'");
                            $rowcasual = mysqli_fetch_assoc($sqlcasual);
                            $casual = $rowcasual['COUNT(*)'];
                            $sqlsick = mysqli_query($conn, "SELECT COUNT(*)  FROM `tbl_leave_record` WHERE `empid` = '$id' AND `date` BETWEEN '$startYear' AND '$endYear' AND `leave_type` = 'sick'");
                            $rowsick = mysqli_fetch_assoc($sqlsick);
                            $sick = $rowsick['COUNT(*)'];
                            $annualsub = $tl1 - $annual;
                            $casualsub = $tl2 - $casual;
                            $sicksub = $tl3 - $sick;
                        }
                    }
                }
            }
        }
    }
?>
<head>
    <title><?php echo $name;?></title>
    <?php require_once "common/head.php";?>
</head>
<body>
    <?php include_once "common/header.php"; ?>    
    <div class="container-fluid">
        <div class="row">
        <?php include_once "common/sidebar.php";?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo $name;?></h1>   
                </div>
                <div>
                    <div class="row g-5">
                    <div class="col-md-5 col-lg-4 order-md-last">
                        <p class="lead">Change Employee Type</p>
                        <?php 
                            if(isset($_GET["et"]) == "success") {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Employee Type Updated Successfully.</div>';
                            }
                            else {
                                echo "";
                            }
                            $sql2 = mysqli_query($conn, "SELECT * FROM tbl_emp_types ORDER BY name ASC");
                        ?>
                        <div class="col-md-5">
                            <form method="POST" action="php/update-emptype.php"> 
                                <label class="form-label">Employee Type</label>
                                <select class="form-select" id='type' name='type' default=<?php $type?> required>
                                    <?php
                                        echo "<option>" . $type . "</option>";
                                        while($row2 = mysqli_fetch_array($sql2)){
                                            echo "<option>" . $row2['name'] . "</option>";
                                        }
                                    ?>
                                </select>
                                <input type="hidden" name="id" value= "<?php echo $id;?>">
                                <br>
                                <button type="submit" class="btn btn-secondary" name='Update' value='Update'>Update</button>
                            </form>
                        </div>
                        <hr class="my-4">
                        <p class="lead">Change Password</p>
                        <form method="POST" action="php/change-password.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" value= "<?php echo $id;?>">
                            <label for="pass-change" class="form-label">Enter New Password</label>
                            <input type="password" class="form-control" id="pass-change" name="pass-change" placeholder="">
                            <label for="pass-change-re" class="form-label">Enter New Password</label>
                            <input type="password" class="form-control" id="pass-change-re" name="pass-change-re" placeholder="">
                            <br>
                            <button type="submit" class="btn btn-secondary" name='Change' value='Change'>Change Password</button>
                        </form>
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
                        <hr class="my-4">
                        <form method="POST" action="delete-employee-verify.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" value= "<?php echo $id;?>">
                            <button type="submit" class="btn btn-danger" name='delete'>Delete Employee</button>
                        </form>
                    </div>
                    <div class="col-md-7 col-lg-8">
                        <p class="lead">Details</p>
                        <form method="POST" target="">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value=<?php echo $email;?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">User ID</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value=<?php echo $id;?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value=<?php echo $type;?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value=<?php echo $status;?>>
                                </div>
                            </div>
                        </form>
                        <p class="lead">Available Leaves</p>
                        <form method="POST" target="">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Annual</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value=<?php echo $annualsub;?>>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Casual</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value=<?php echo $casualsub?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Sick</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value=<?php echo $sicksub;?>>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4">
                        <p class="lead">Leave History - Current Year</p>
                        <form method='GET' action='export.php' enctype='multipart/form-data'>
                            <input type='hidden' name='export' value="empleave">
                            <input type='hidden' name='systitle' value="Leave Report - Emp ID <?php echo $id." - ".$currYear;?>">
                            <input type='hidden' name='id' value="<?php echo $id;?>">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Export</button>
                        </form>
                        <table class='table table-striped table-bordered table-sm table-hover' id='dataTable'>
                            <thead>
                                <tr>
                                    <th scope='col'>Date</th>
                                    <th scope='col'>Type</th>
                                    <th scope='col'>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = mysqli_query($conn,"SELECT * FROM `tbl_leave_record` WHERE empid = '$id' AND `date` BETWEEN '$startYear' AND '$endYear' AND status = 'Approved'");
                                     if(mysqli_num_rows($sql) > 0){
                                        while($row = mysqli_fetch_array($sql)){
                                            echo "<tr>";
                                                echo "<td>" . $row['date'] . "</td>";
                                                echo "<td>" . $row['leave_type'] . "</td>";
                                                echo "<td>" . $row['descripition'] . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    else{
                                        echo "<tr>";
                                            echo "<td colspan='7'> No record found. </td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>  
                </div>
                <hr class="my-4">
                <p class="lead">Attendance History</p>
                <form method='GET' action='export.php' enctype='multipart/form-data'>
                    <input type='hidden' name='export' value="empattendance">
                    <input type='hidden' name='systitle' value="Attendance Report - Emp ID <?php echo $id;?>">
                    <input type='hidden' name='id' value="<?php echo $id;?>">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Export</button>
                </form>
                <table class='table table-striped table-bordered table-sm table-hover' id='dataTable'>
                    <thead>
                        <tr align="center">
                            <th scope='col' colspan='3'>Start</th>
                            <th scope='col' colspan='3'>End</th>
                            <th scope='col' rowspan='2' style='vertical-align : middle;'>Tot Time</th>
                            <th scope='col' rowspan='2' style='vertical-align : middle;'>OT</th>
                        </tr>
                        <tr align="center">
                            <th scope='col'>Date</th>
                            <th scope='col'>Time</th>
                            <th scope='col'>Location</th>
                            <th scope='col'>Date</th>
                            <th scope='col'>Time</th>
                            <th scope='col'>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = mysqli_query($conn,"SELECT * FROM `tbl_attendance` WHERE Emp_ID = '$id' ORDER BY `tbl_attendance`.`rowid` DESC");
                            function format_interval(DateInterval $interval) {
                                $result = "";
                                if ($interval->d) { $result .= $interval->format("%d days "); }
                                if ($interval->h) { $result .= $interval->format("%hh:"); }
                                if ($interval->i) { $result .= $interval->format("%im:"); }
                                if ($interval->s) { $result .= $interval->format("%ss"); }
                                return $result;
                            }
                            if(mysqli_num_rows($sql) > 0){
                                while($row = mysqli_fetch_array($sql)){
                                    echo "<tr>";
                                        echo "<td>" . $row['in_date'] . "</td>";
                                        echo "<td>" . $row['in_time'] . "</td>";
                                        echo "<td>" . $row['in_location'] . "</td>";    
                                        echo "<td>" . $row['out_date'] . "</td>";
                                        echo "<td>" . $row['out_time'] . "</td>";
                                        echo "<td>" . $row['out_location'] . "</td>";
                                        $first_date = new DateTime($row['in_date'] . $row['in_time']);
                                        $outdate = $row['out_date'];
                                        $outtime = $row['out_time'];
                                        if(!$outdate == NULL && !$outtime == NULL){
                                            $second_date = new DateTime($outdate . $outtime);
                                            $difference = $first_date->diff($second_date);
                                            echo "<td>" . format_interval($difference) . "</td>";
                                        }
                                        else{
                                            echo "<td>" . "" . "</td>";
                                        } 
                                        echo "<td>" . $row['ot_time'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                            else{
                                echo "<tr>";
                                    echo "<td colspan='7'> No record found. </td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </main> 
        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>