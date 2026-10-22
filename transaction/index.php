<?php
	require_once("../controller/session.php");
	$user_id = $_SESSION['user_session'];
	
	$user = $login->getUser($user_id);
	
	if(isset($_GET['logout'])){
		if($login->doLogout())
			header("Location: ../");	
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Online</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../resource/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../resource/css/transaction.css">
	<link rel="stylesheet" href="../resource/css/login.css">
	<link rel="stylesheet" type="text/css" href="../resource/font-awesome/css/font-awesome.min.css">
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../transaction/">ICU Project</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="../studentList/">Student List</a></li>
                    <!-- <li><a href="statistics.php">Statistics</a></li> -->
                    <li><a href="../report/">Report</a></li>
                    <!-- <li><a href="about.php">About</a></li> -->
                </ul>
                <ul class="nav navbar-nav navbar-right" style="padding-right: 15px;">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-user" style="color:#000;"></span>&nbsp;Hi' <?php echo $user ?> &nbsp;</span></a>
						<ul class="dropdown-menu dropdown-yellow dropdown-caret dropdown-menu-right">
							<li>
								<a href="?logout=true">
									<span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out
								</a>
							</li>
						</ul>
					</li>
				</ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container main-container">
    	<div class="jumbotron">
	        <button type="button" id="open-transaction" name="open-transaction" class="btn btn-primary"  data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in fa-lg"></i>&nbsp;Open Transaction</button>

	        <div class="timeHolder">
	            <?php 
	            	date_default_timezone_set("Asia/Manila");
	            	echo "<b>" . date("m/d/Y") . "</b>";  
	            ?>
	            <span id="currentTime"></span>
       		</div>
   		</div>
    </div>

    <div class="studentLoggedInContainer">
    <form class="form online-list">
        <table class="table table-bordered table-fixed table-hover ONLINEtable" id="ONLINEtable">
            <caption align="center"><h3>Students Currently Logged In(<b id="count"></b>)</h3></caption>
            <thead>
                <tr>
                    <th>CompID</th>
                    <th>IDNumber</th>
                    <th>DateLog</th>
                    <th>Student Name</th>
                    <th>Balance</th>
                    <th>TimeLeft</th>
                    <th>Expires</th>
                    <!-- <th>Log Out</th>  -->
                </tr>
            </thead>
            <tbody id="ONLINElist"> 
            </tbody>
        </table>
    </form>
	</div>
    
    <footer class="footer" id="footerr">
        <div class="container footer-container">
            <p class="text-muted">COPYRIGHT&copy; by CHOLO</p>
        </div>
    </footer>
    
    <?php 
    	include('loginStudentModal.php');
        include('logoutStudentModal.php');
    ?>

</body>
	<script src="../resource/js/jquery.min.js"></script>
	<script src="../resource/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../resource/js/tscripts.js"></script>
	<script type="text/javascript" src="../resource/js/displayTimeHome.js"></script> 
	<script type="text/javascript" src="../resource/js/displayTimeModal.js"></script>
</html>