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
	<title>Student List</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../resource/css/bootstrap.min.css">
	<link rel="stylesheet" href="../resource/css/login.css">
    <link rel="stylesheet" type="text/css" href="../resource/css/studentList.css">
    <link rel="stylesheet" type="text/css" href="../resource/font-awesome/css/font-awesome.min.css">
	<!-- <script src="../resource/js/jquery-3.2.1.js"></script> -->
    <script src="../resource/js/jquery.min.js"></script>
	<script src="../resource/js/bootstrap.min.js"></script>

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
                    <li class="active"><a href="../studentList/">Student List</a></li>
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

    <!--START HTML TBALE LAYOUT-->
    <div class="container list" style="margin-top: 60px;">
        <!--START HTML STRING SEARCH INPUT-->
            <div class="row">
                <form role="form" id="LISTNAME_frm">
                    <div class="form-group below-search">                    
                        <div class="input-group custom-search-form">
                            <select class="form-control" id="selectOption" name="searchOption">
                                <option value="studentID">Student Number</option>
                                <option value="lastName">Last Name</option>
                                <option value="firstName">First Name</option>
                            </select>    
                            <input type="text" id="LISTNAME_search_txt" class="form-control" placeholder="Search Student">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="LISTNAME_search_btn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                    </div>
                </form>
            </div>
            <!--END HTML STRING SEARCH INPUT-->
            <div class="row">
                <div class="divAddStudent">
                    <a href="Javascript:void(0)" class="btn btn-md btn-primary " id="btnAddStudent" data-toggle="modal" data-target="#add-modal">
                        <i class="fa fa-plus fa-lg" id="btnAdd" aria-hidden="true">&nbsp;Add&nbsp;Student</i>
                    </a>
                </div>
            </div>
            <div>
                <!--START HTML NUMBER OF ITEM PER PAGE BLOCK-->
                <div style="float:right;">
                    <label>
                        <div style="display:inline-block">Rows per page: </div>
                        <div style="display:inline-block">
                            <select class="form-control input-sm" id="nav_rowsPerPage">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                    </label>
                </div>
                <!--END HTML NUMBER OF ITEM PER PAGE BLOCK-->                                    
                <!--START TOTAL ITEM INFO BLOCK-->
                <div style="float:left;">
                    <label>
                        <span id="nav_info"></span>
                    </label>
                </div>
            <!--END TOTAL ITEM INFO BLOCK-->
            </div>

            <div class="clearfix"></div>                                
            <!--START RESPONSIVE TBALE-->
            <div class="table-responsive" id="LISTNAME_tbl_cover">
                <table class="table table-striped table-bordered table-hover" id="LISTNAME_tbl">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SURNAME</th>
                            <th>FIRSTNAME</th>
                            <th>MI</th>
                            <th>STUDENT NUMBER</th>
                            <th>BALANCE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>                                         

                    </tbody>
                </table>
            </div>
        <!--END RESPONSIVE TBALE-->  
        <!--START PAGINATION BUTTON-->
        <div class="form-group pagination-div" style="width:100%; text-align:center;">
            <button type="submit" class="btn btn-default" id="nav_first"><i class="fa fa-fast-backward"></i> First</button>
            <button type="submit" class="btn btn-default" id="nav_prev"><i class="fa fa-caret-left"></i> Prev</button>
            <select class="nav_pageNum btn btn-default" id="nav_currentPage"></select>
            <button type="submit" class="btn btn-default" id="nav_next">Next <i class="fa fa-caret-right"></i></button>
            <button type="submit" class="btn btn-default" id="nav_last">Last <i class="fa fa-fast-forward"></i></button>
        </div>
        <!--END PAGINATION BUTTON-->
    </div>
        <?php
            include('addStudentModal.php');
            include('editStudentModal.php');
            include('deleteStudentModal.php');
        ?>
</body>
	<script type="text/javascript" src="../resource/js/scripts.js"></script>
</html>