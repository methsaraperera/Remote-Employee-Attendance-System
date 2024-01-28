<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
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
            .form-signin .form-floating:focus-within {
                z-index: 2;
            }
            .form-signin input[type="email"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>
    </head>
    <body class="text-center"> 
        <main class="form-signin">
            <h1 class="h3 mb-3 fw-normal">COLMA HR Admin</h1>
            <?php
                if(isset($_GET["status"])){
                    if(isset($_GET["status"]) == "nouser") {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">No user exist.</div>';
                    }
                    elseif(isset($_GET["status"]) == "invalid") {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Invalid usrname or password.</div>';
                    }
                    else{
                        echo '';
                    }
                }
            ?>
            <form method="POST" action="php/login.php" enctype="multipart/form-data">    
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="Login" value="Login">Login</button>
            </form><br>
            <a href="forgot-password" class="link-secondary">Forgot Password</a>
        </main>  
    </body>
</html>