<?php
session_start();
require_once "controller/config.php";
if ($login->isLoggedIn()) {
    header("Location: transaction/");
}

if (isset($_POST['btn-login'])) {
    $name = strip_tags($_POST['username']);
    $pass = strip_tags($_POST['password']);
    if ($login->doLogin($name, $pass)) {
        header("Location: transaction/");
    } else {
        $error = "Error";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ICSLM - DCST</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="resource/css/bootstrap.min.css">
        <link rel="stylesheet" href="resource/css/login.css">
        <script src="resource/js/jquery.min.js"></script>

        <script src="resource/js/bootstrap.min.js"></script>
        <script src="resource/js/jquery.backstretch.js"></script>
    </head>
    <body>
        <script>
            $.backstretch([
                "resource/images/2.jpg",
                "resource/images/3.jpg",
                "resource/images/4.jpg"
            ], {
                fade: 750, //Speed of Fade
                duration: 5000 	//Time of image display
            });
        </script>
        <div class="container">
            <div class="row">
                <div class="col-md-7 text-center" >
                    <h1 class="slogan">DCST Computer Center</h1>
                    <hr />
                    <span class="sub-slogan">Internet Cafe Student LogIn Monitoring System</span>				
                </div>
                <div class="col-md-3 col-md-offset-1">
                    <br /><br /><br /><br /><br />
                    <div class="panel panel-primary">										
                        <div class="panel-heading">Login First</div>
                        <img src="resource/images/man3.png" width="80px" class="center-block" style="margin-top: 10px"/>						  
                        <div class="panel-body">
                            <div class="horizontal-line"></div>
                            <form method="post">

                                <?php if (isset($error)) { ?>
                                    <div class="inner-addon left-addon form-group">
                                        <i class="glyphicon glyphicon-user"></i>
                                        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus/>
                                        <div class="error" ><i class="glyphicon glyphicon-warning-sign text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="inner-addon left-addon form-group">
                                        <i class="glyphicon glyphicon-lock"></i>
                                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                                        <div class="error" ><i class="glyphicon glyphicon-warning-sign text-danger"></i>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="inner-addon left-addon form-group">
                                        <i class="glyphicon glyphicon-user"></i>
                                        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus/>
                                    </div>
                                    <div class="inner-addon left-addon form-group">
                                        <i class="glyphicon glyphicon-lock"></i>
                                        <input type="password" name="password" class="form-control" placeholder="Password"/>										
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">								
                                            <button type="submit" name="btn-login" class="form-control btn-success">
                                                <span class="glyphicon glyphicon-log-in"></span> Login</button>
                                        </div>
                                    </div>
                                </div>
                                <br />
                            </form>
                        </div>							
                    </div> 
                </div>
            </div>
        </div>
    </body>
</html>