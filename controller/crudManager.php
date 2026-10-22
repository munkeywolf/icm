<?php
	require_once('config.php');
	
	$action=isset($_POST['action'])?$_POST['action']:"";
	
	if($action == "studentList")
	{
        $scrud->getStudentList();
	}
	elseif($action == "addStudent")
	{
		$scrud->addStudent();
	}
	elseif($action == "studentInfoEdit")
	{
        $scrud->getStudentInfo();
	}
	elseif($action == "studentInfoUpdate")
	{
        $scrud->updateStudentInfo();
	}
    elseif($action == "deleteStudent")
    {
        $scrud->deleteStudent();
    }


    /************************************************************************/

	elseif($action == "pcList")
	{
        $tcrud->fillComputer();
	}
	elseif($action == "findStudent") 
	{
        $tcrud->findStudentData();
	}
	elseif($action == "transhistory")
	{
        $tcrud->transactionHistory();
	}
	elseif($action == "addToEnrolled")
	{
        $tcrud->addToEnrolled();
	}
	elseif($action == "createTransaction")
	{
        $tcrud->loginStudent();
	}
	elseif($action == "showLoggedIn")
	{
        $tcrud->getOnlineStudents();
	}
	elseif($action == "forLogoutInfo")
	{
        $tcrud->studentLogInfo();
	}
	elseif ($action == "logoutStudent") 
	{
        $tcrud->logoutStudent();
	}
	elseif($action == "balanceAndEntry")
	{
        $tcrud->getBalEntry();
	}

    /*****************************************************************************/

	elseif($action == "viewBySem")
	{
        $rcrud->transactionBySem();
	}
	elseif($action == "viewByDate")
	{
        $rcrud->transactionByDate();
	}
	elseif($action == "viewByID")
	{
        $rcrud->transactionByID();
	}


?>