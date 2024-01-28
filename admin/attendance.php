<?php
session_start();
if(!isset($_SESSION['adminid'])){
	header("location: login.php");
}
    require_once "../config.php";
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
                    <h1 class="h2">Attendance</h1>   
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <form method="GET" action='attendance' enctype='multipart/form-data'>
                            <div class="btn-group me-2">
                                <input placeholder="Start Date" class="btn btn-sm btn-outline-secondary input" type="text" onfocus="(this.type='date')" onblur="(this.type='date')" id="startDate" name="startDate" required/>
                                <input placeholder="End Date" class="btn btn-sm btn-outline-secondary input" type="text" onfocus="(this.type='date')" onblur="(this.type='date')" id="endDate" name="endDate" required/>
                                <button type="submit" class="btn btn-sm btn-secondary">Search</button>
                            </div>
                        </form> 
                        <form method='GET' action='export.php' enctype='multipart/form-data'>
                            <input type='hidden' name='export' value="attendance">
                            <input type='hidden' name='systitle' value="Attendance Report - All Employees">
                            <?php
                                if(isset($_GET['startDate'])) {
                                    echo "<input type='hidden' name='startDate' value=".$_GET['startDate'].">";
                                }
                                if(isset($_GET['startDate'])) {
                                    echo "<input type='hidden' name='endDate' value=".$_GET['endDate'].">";
                                }
                            ?>
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Export</button>
                        </form>
                    </div>
                </div>
                <br>
                <div>
                    <table class='table table-bordered table-striped table-sm table-hover table-responsive' id='dataTable'>
                        <thead>
                            <tr align="center">
                                <th scope='col' rowspan='2' style='vertical-align : middle;'>Emp ID</th>
                                <th scope='col' style='vertical-align : middle;'>Start Date</th>
                                <th scope='col' style='vertical-align : middle;'>Start Time</th>
                                <th scope='col' style='vertical-align : middle;'>Start Location</th>
                                <th scope='col' style='vertical-align : middle;'>End Date</th>
                                <th scope='col' style='vertical-align : middle;'>End Time</th>
                                <th scope='col' style='vertical-align : middle;'>End Location</th>
                                <th scope='col' rowspan='2' style='vertical-align : middle;'>Tot Time</th>
                                <th scope='col' rowspan='2' style='vertical-align : middle;'>OT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $start = NULL;
                                $end = NULL;
                                if(isset($_GET['startDate'])) {
                                    $start = $_GET['startDate'];
                                }
                                if(isset($_GET['endDate'])) {
                                    $end = $_GET['endDate'];
                                }
                                if ($start === NULL && $end === NULL){
                                    $sql = mysqli_query($conn,"SELECT * FROM `tbl_attendance` ORDER BY `tbl_attendance`.`rowid` DESC");
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
                                                echo "<td>" . $row['Emp_ID'] . "</td>";
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
                                }
                                else{
                                    $sql = mysqli_query($conn,"SELECT * FROM `tbl_attendance` WHERE `in_date` >= '$start' AND `in_date` <= '$end' ORDER BY `rowid` DESC");
                                    function format_interval(DateInterval $interval) {
                                        $result = "";
                                        if ($interval->d) { $result .= $interval->format("%d days "); }
                                        if ($interval->h) { $result .= $interval->format("%h hours "); }
                                        if ($interval->i) { $result .= $interval->format("%i minutes "); }
                                        if ($interval->s) { $result .= $interval->format("%s seconds "); }
                                        return $result;
                                    }
                                    if(mysqli_num_rows($sql) > 0){
                                        while($row = mysqli_fetch_array($sql)){
                                            echo "<tr>";
                                                echo "<td>" . $row['Emp_ID'] . "</td>";
                                                echo "<td>" . $row['in_date'] . "</td>";
                                                echo "<td>" . $row['in_time'] . "</td>";
                                                echo "<td>" . $row['in_location'] . "</td>";    
                                                echo "<td>" . $row['out_date'] . "</td>";
                                                echo "<td>" . $row['out_time'] . "</td>";
                                                echo "<td>" . $row['out_location'] . "</td>";
                                                $first_date = new DateTime($row['in_date'] . $row['in_time']);
                                                $second_date = new DateTime($row['out_date'] . $row['out_time']);
                                                $difference = $first_date->diff($second_date);
                                                echo "<td>" . format_interval($difference) . "</td>";
                                                echo "<td>" . $row['ot_time'] . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    else{
                                        echo "<tr>";
                                            echo "<td colspan='8'> No record found. </td>";
                                        echo "</tr>";
                                    }
                                }   
                            ?>
                        </tbody>
                    </table>
                </div>
            </main> 
        </div>
    </div>
                        
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>