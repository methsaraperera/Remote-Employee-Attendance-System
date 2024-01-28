<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forgot Passoword</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                height: 100%;
            }
            body {
                display: flex;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
            }
            .form-signin {
                width: 100%;
                max-width: 330px;
                padding: 15px;
                margin: auto;
            }
        
        </style>
    </head>
    <body class="text-center"> 
        <main class="form-signin">
            <h1 class="h3 mb-3 fw-normal">COLMA HR Admin</h1>
            <br>
            
            <?php
                if(isset($_GET["status"])){
                    if($_GET['status'] == 'success'){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Request submitted contact your assisting admin to reset your password.</div>';
                    }
                    elseif($_GET['status'] == 'invalid'){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">User does not exist.</div>';
                    }
                }
                else{
                    echo "";
                }
            ?>
            <?php
            require_once "../config.php";
                $sql2 = mysqli_query($conn, "SELECT * FROM tbl_admin");
            ?>
            <form method="POST" action="php/forgot-password.php" enctype="multipart/form-data">    
                <label class="form-label">Enter email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <br>
                <label class="form-label">Assisting admin ID to reset password</label>
                <select class="form-select" id='assist' name='assist' required>
                    <?php
                        echo "<option>"." "."</option>";
                        while($row2 = mysqli_fetch_array($sql2)){
                            echo "<option>".$row2['Admin_ID']." ".$row2['Admin_Name']."</option>";
                        }
                    ?>
                </select>
                <br>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="reset" value="reset">Reset Password</button>
            </form><br>
        </main>  
    </body>
</html>