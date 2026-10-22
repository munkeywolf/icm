<?php
	$DB_host = "localhost";
	$DB_user = "root";
	$DB_pass = "";
	$DB_name = "icu_test";
	//$charset = "utf8";
	try{
		//$DB_con = new PDO("mysql:host=".$DB_host.";dbname=".$DB_name,$DB_user, $DB_pass);
		$DB_con = new PDO("mysql:host=".$DB_host.";dbname=".$DB_name,$DB_user,$DB_pass);
		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $DB_con->exec("set names utf8");
	
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	
	include_once 'login.php';
	$login = new Login($DB_con);
    include_once 'TransactionDAO.php';
    $tcrud = new Transaction($DB_con);
    include_once 'StudentListDAO.php';
    $scrud = new Student($DB_con);
    include_once 'ReportDAO.php';
    $rcrud = new Report($DB_con);
?>