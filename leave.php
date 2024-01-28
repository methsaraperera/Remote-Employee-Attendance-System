<?php
session_start();
require_once "config.php";
if(!isset($_SESSION['uid'])){
	header("location: login.php");
}
$uid = $_SESSION['uid'];
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>COLMA HR | Apply Leave</title>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script language="javascript" type="text/javascript" src="location.js"></script>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
	<section class="form">
		<header>COLMA HR</header>
        <p>APPLY LEAVE</p>
        <?php 
            if(isset($_GET["status"])){ 
                if($_GET['status'] == 'can-true'){
                    echo '<div class="success">Leave canceled successfully.</div>';
                }
            }
            
            $sql = mysqli_query($conn,"SELECT rowid, date, leave_type, status from `tbl_leave_record` WHERE empid = $uid AND stat = '0'");
            if(mysqli_num_rows($sql) > 0){
                while($row = mysqli_fetch_array($sql)){
                    if ($row['status'] == "In Review"){
                        echo "<div class='notice' style='border: 0px;'>Your ".$row['leave_type']." leave request for ".$row['date']." is still on review. &nbsp
                        </div>";
                    }
                    elseif ($row['status'] == "Approved"){
                        echo "<div class='success'>Your ".$row['leave_type']." leave request for ".$row['date']." got approved. &nbsp
                            <div>
                                <form method='POST' action='php/leave-ok.php' enctype='multipart/form-data'>
                                    <input type='hidden' id='rowid' name='rowid' value=".$row['rowid'].">
                                    <button class='button-small-green' name='ok' value='ok'>Ok</button>
                                </form>	
                            </div>	
                        </div>";
                    }
                    elseif ($row['status'] == "Declined"){
                        echo "<div class='error'>Your ".$row['leave_type']." leave request for ".$row['date']." got declined. &nbsp
                            <div>
                                <form method='POST' action='php/leave-ok.php' enctype='multipart/form-data'>
                                    <input type='hidden' id='rowid' name='rowid' value=".$row['rowid'].">
                                    <button class='button-small-red' name='ok' value='ok'>Ok</button>
                                </form>	
                            </div>	
                        </div>";
                    }
                    
                }
            }
            if(isset($_GET["status"])){
                if($_GET['status'] == 'success'){
                    echo '<div class="success">Leave submitted to the review of admin.</div>';
                }
                if($_GET['status'] == 'failed'){
                    echo '<div class="error">Failed to submit leave request.</div>';
                }
                elseif($_GET['status'] == 'sessionrunning'){
                    echo '<div class="error">Error. End the current working session before applying for a leave.</div>';
                }
                elseif($_GET['status'] == 'repeat'){
                    echo '<div class="error">Error. You can not apply more than 1 leave per day.</div>';
                }
            }
            else{
                echo "";
            }
        ?>
		<form method="POST" action="php/leave.php" enctype="multipart/form-data">
            <label>Date</label><br>
            <input placeholder="mm/dd/yyyy" class="button-three" style="text-align:left; padding-left:10px; padding-right:10px; border-radius: 5px;" type="text" onfocus="(this.type='date')" onblur="(this.type='date')" name="date" required/><br>
            <label>Leave Type</label><br>
            <select name="type"  class="button-three" placeholder="" style="text-align:center; padding-left:10px; padding-right:10px; border-radius: 5px;" required>
                <option value="annual" class="select" style="text-align:left;">Annual</option>
                <option value="casual" class="select" style="text-align:left;">Casual</option>
                <option value="sick" class="select" style="text-align:left;">Sick</option>
            </select><br>
            <label>Describe why you're taking the leave</label>
            <input type="textarea" class="text-area" id="description" name="description" placeholder="" required>
            <button type="submit" class="button-three" name="submit" value="submit" style="background: #333; color: #fff;">Submit</button>    
        </form>
	</section>
    <p>UPCOMING LEAVES</p>
    <div class='notice' style='border: 0px; background-color: #fff;'>
        <table class="Table">
            <thead>
                <tr style='align-items: center;'>
                    <td>Date</td>
                    <td>Type</td>
                    <td>Decision</td>
                    <td>Review</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sysdate = "".date("Y-m-d");    
                    $search = mysqli_query($conn,"SELECT *  FROM `tbl_leave_record` WHERE empid = $uid AND date > '$sysdate' AND status = 'Approved'");
                    while($row = mysqli_fetch_array($search)){
                        echo "<form method='POST' action='php/cancel-leave.php' enctype='multipart/form-data'>";
                            echo "<tr>";
                                echo "<td>".$row['date']."</td>";
                                echo "<td scope='col'>".$row['leave_type']."</td>";
                                echo "<td scope='col'>".$row['status']."</td>";
                                echo "<input type='hidden' id='rowid' name='rowid' value=".$row['rowid'].">";
                                echo "<td scope='col'> 
                                <button type='submit' class='button-small-none' name='cancel' value='cancel'>Cancel Leave</button>    
                                </td>";    
                            echo "</tr>";
                        echo "</form>";
                    }
                ?>   
            </tbody>  
        </table>
        <section class="form">
            <div class="link">Get back to <a href="index.php">Dashboard</a></div>
        </section>
    </div>
    
</div>

</body>
</html>