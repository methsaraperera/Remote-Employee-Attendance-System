<?php
session_start();
require_once "../config.php";
if(isset($_POST['Register']))
{
    $name = ($_POST['name']);
    $email = ($_POST['email']);
    $pw = ($_POST['password']);
    $pwre = ($_POST['passwordre']);
    $sq1 = ($_POST['sq1']);
    $sa1 = ($_POST['sa1']);
    $sq2 = ($_POST['sq2']);
    $sa2 = ($_POST['sa2']);
    $sq3 = ($_POST['sq3']);
    $sa3 = ($_POST['sa3']);
    date_default_timezone_set('Asia/Colombo');
    $date = "".date("Y-m-d");
    $time = "".date("H:i:s");
    $datetime = ($date." ".$time);
    if(!empty($name) && !empty($email) && !empty($pw) && !empty($pwre) && !empty($sq1) && !empty($sa1) && !empty($sq2) && !empty($sa2) && !empty($sq3) && !empty($sa3)){
        if ($pw != $pwre){
            setcookie("pwerror", "1", time() + 5, "/");
		    echo '<meta http-equiv="refresh" content="0; URL=../register.php" />';
        }
        else{
            $sql = mysqli_query($conn, "SELECT * FROM `tbl_employee` WHERE Emp_Email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                setcookie("emailrepeat", "1", time() + 5, "/");
		        echo '<meta http-equiv="refresh" content="0; URL=../register.php" />';
            }
            else{
                $insert_query = mysqli_query($conn, "INSERT INTO `tbl_signuprequest` (`name`, `email`, `password`, `sq1`, `sa1`, `sq2`, `sa2`, `sq3`, `sa3`, `date`)
                                VALUES ('{$name}', '{$email}','{$pw}', '{$sq1}', '{$sa1}', '{$sq2}', '{$sa2}', '{$sq3}', '{$sa3}',  '{$datetime}')");
                                
                if($insert_query){
                    $select_sql2 = mysqli_query($conn, "SELECT * FROM tbl_signuprequest WHERE email = '{$email}'");
                    if(mysqli_num_rows($select_sql2) > 0){
                        setcookie("success", "1", time() + 5, "/");
		                echo '<meta http-equiv="refresh" content="0; URL=../register.php" />';
                    }else{
                    }
                }else{
                    setcookie("error", "1", time() + 5, "/");
		            echo '<meta http-equiv="refresh" content="0; URL=../register.php" />';
                }
            }
        }
    }
    else{
    }
}
?>