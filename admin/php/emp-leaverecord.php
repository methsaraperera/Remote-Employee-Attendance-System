<?php
require_once "../../config.php";
$currYear = date('Y');
$startYear = $currYear . "-01-01";
$endYear = $currYear . "-12-31";
$id = "54";
?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<table id='dataTable'>
    <thead>
        <tr>
            <th scope='col'>Date</th>
            <th scope='col'>Type</th>
            <th scope='col'>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = mysqli_query($conn,"SELECT * FROM `tbl_leave_record` WHERE empid = '$id' AND `date` BETWEEN '$startYear' AND '$endYear'");
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
<body onload="dataExport()" data-type="excel">
        </body>
<button type="button" class="btn btn-sm btn-outline-secondary dataExport" data-type="excel">Export .xls</button>
<script src="../tableExport/tableExport.js"></script>
<script type="text/javascript" src="../tableExport/jquery.base64.js"></script>
<script src="../js/export.js"></script>