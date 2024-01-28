<?php
    session_start();
    unset($_SESSION['uid']);
    echo '<meta http-equiv="refresh" content="0; URL=../login.php"/>';
?>