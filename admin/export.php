<?php
    session_start();
    if(!isset($_SESSION['adminid'])){
        header("location: login.php");
    }
    require_once "../config.php";
    date_default_timezone_set('Asia/Colombo');
    $sysdate = "".date("Y-m-d");
    $systime = "".date("H:i:s"); 
    $currYear = date('Y');
    $startYear = $currYear . "-01-01";
    $endYear = $currYear . "-12-31"; 
?>
<head>
    <title><?php echo $_GET["systitle"]." $sysdate-$systime";?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <style>
        body {
            margin-top: 20px;
            margin-left: 50px;
            margin-right: 50px;
        }
    </style>
</head>
<body>
    <script>
        function downloadPDFWithBrowserPrint() {
            window.print();
        }
        document.querySelector("table").addEventListener('click', downloadPDFWithBrowserPrint);
    </script>
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="btn-toolbar mb-2 mb-md-0">    
                <form>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.href = 'dashboard.php';"> < Back to Dashboard</button>
                    </div> 
                </form>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                <form>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-primary" onClick="downloadPDFWithBrowserPrint()">Export .pdf</button>
                    </div>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-primary dataExport" data-type="excel">Export .xls</button>
                    </div>
                </form>    
            </div>
        </div>
        <br>

        <div class="row">
            <div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <strong>COLMA HR System</strong>
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <em><?php echo "Date: ".$sysdate. "<br> Time: ".$systime;?></em>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <h3><?php if(isset($_GET["systitle"])){echo $_GET["systitle"];}?></h3>
                        <p><?php if(isset($_GET["startDate"])){echo $_GET["startDate"];} echo" - "; if(isset($_GET["endDate"])){echo $_GET["endDate"];}?></p>
                        <br>
                    </div>
                    <?php
                        if(isset($_GET["export"])){
                            if($_GET["export"] == "attendance"){
                                echo"<table class='table table-striped table-bordered table-sm table-hover table-responsive' id='dataTable'>
                                    <thead>
                                        <tr align='center'>
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
                                    <tbody>";
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
                                        else {
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
                                    echo "</tbody>
                                </table>";
                            }
                            elseif($_GET["export"] == "empattendance"){
                                echo"<table class='table table-striped table-bordered table-sm table-hover' id='dataTable'>
                                    <thead>
                                    <tr align='center'>             
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
                                    <tbody>";
                                    $sql = mysqli_query($conn,"SELECT * FROM `tbl_attendance` WHERE Emp_ID = ". $_GET["id"]." ORDER BY `tbl_attendance`.`rowid` DESC");
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
                                    echo "</tbody>
                                </table>";
                            }
                            elseif($_GET["export"] == "empleave"){
                                echo"<table class='table table-striped table-bordered table-sm table-hover' id='dataTable'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Date</th>
                                            <th scope='col'>Type</th>
                                            <th scope='col'>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                        $sql = mysqli_query($conn,"SELECT * FROM `tbl_leave_record` WHERE empid = ". $_GET["id"]." AND `date` BETWEEN '$startYear' AND '$endYear'");
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
                                    echo "</tbody>
                                </table>";
                            }
                            elseif($_GET["export"] == "emplist"){
                                echo"<table class='table table-striped table-bordered table-sm table-hover table-responsive' id='dataTable'>
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
                                        echo "</tr>";
                                    } 
                                    echo "</tbody>
                                </table>";
                            }
                            elseif($_GET["export"] == "types"){
                                echo"<table class='table table-striped table-bordered table-sm table-hover table-responsive' id='dataTable'>
                                        <thead>
                                            <tr>
                                                <th scope='col'># </th>
                                                <th class='col'>Employee Type</th>
                                                <th class='col'>Annual Leaves</th>
                                                <th class='col'>Casual Leaves</th>
                                                <th class='col'>Sick Leaves</th>
                                                <th class='col'>Max OT Hours - Day</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                        $sql = mysqli_query($conn, "SELECT * FROM `tbl_emp_types` ORDER BY `typeid` ASC");
                                        while($row = mysqli_fetch_array($sql)){
                                            echo "<form method='POST' action='php/edit-emptypes.php' enctype='multipart/form-data'>";
                                                echo "<tr>";
                                                    echo "<td>" . $row['typeid'] . "</td>";
                                                    echo "<td>" . $row['name'] . "</td>";
                                                    echo "<td>" . $row['annual'] . "</td>";
                                                    echo "<td>" . $row['casual'] . "</td>";
                                                    echo "<td>" . $row['sick'] . "</td>";
                                                    echo "<td>" . $row['max_ot_hours'] . "</td>"; 
                                                echo "</tr>";
                                            echo "</form>";
                                        }
                                    echo "</tbody>
                                </table>";
                            }
                            elseif($_GET["export"] == "admins"){
                                echo"<table class='table table-striped table-bordered table-sm table-hover table-responsive' id='dataTable'>
                                <thead>
                                    <tr>
                                        <th scope='col'># </th>
                                        <th scope='col'>Name</th>
                                        <th scope='col'>Email</th>
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
                                                   
                                            echo "</tr>";
                                        echo "</form>";
                                    }
                                echo "</tbody>
                            </table>";
                            }
                        }      
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="tableExport/tableExport.js"></script>
    <script type="text/javascript" src="tableExport/jquery.base64.js"></script>
    <script src="js/export.js"></script>
</body>


    