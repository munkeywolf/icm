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
	<title>System Report</title>
    <link rel="stylesheet" type="text/css" href="../resource/css/report.css">
    <link rel="stylesheet" href="../resource/css/datepicker.css">
	<!-- <link href="../resource/css/bootstrap.css" rel="stylesheet"> -->
	<link href="../resource/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../resource/css/dashboard.css">
	<link rel="stylesheet" href="../resource/font-awesome/css/font-awesome.min.css">
  	<script type="text/javascript" src="../resource/js/jquery.min.js"></script>
    <script type="text/javascript" src="../resource/js/bootstrap-datepicker.js"></script>
  	<script type="text/javascript" src="../resource/js/bootstrap.min.js"></script>

</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" id="tae">
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
                    <li class="active"><a href="../report/">Report</a></li>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar ">
                <form class="form-horizontal" id="viewReport">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <select name="atSchoolYear" class="form-control" id="atSchoolYear" required>
                                <option value=""></option>
                                <option value="1">2016&nbsp;-&nbsp;2017</option>
                                <option value="2">2017&nbsp;-&nbsp;2018</option>
                            </select>
                        </div>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="bySem" value="1">First Semester</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="bySem" value="2">Second Semester</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="bySem" value="3">Summer</label>
                    </div>

                    <div style="margin-top: 10px;">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" placeholder="click" class="form-control" id="byDate" readonly>
                            </div>
                        </div>
   
                    </div>
                    <div style="margin-top: 10px;">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="studentID" id="byStud" placeholder="00-0-00000">
                            </div>
                        </div>
                            <button type="submit" id="viewTransaction" class="btn btn-md btn-primary"><i class="fa fa-eye fa-lg"></i>&nbsp;View</button>
                    </div>
                </form>

                <div class="printButton">
                    <button type="button" id="printButton" class="btn btn-md btn-primary" onclick="window.print()"><i class="fa fa-print fa-lg"></i>&nbsp;Print</button>
                </div>

            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="viewDiv">
                <div class="printDiv" id="printDiv">
                    
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="../resource/js/pscripts.js"></script>

</html>