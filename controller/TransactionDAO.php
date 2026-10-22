<?php
    Class Transaction{
        private $db;
        private $schoolTime = "20173";
        function __construct($DB_con){
            $this->db = $DB_con;
        }



/**********************************************************************************************************************************/

        public function findStudentData(){
            $searchID = $_POST['searchID'];

            try
            {
                $dataQry = "SELECT  e.studentID , `is_consumed` , `balance` , `lastName` , `firstName` , `middleName` ,".
                    "(CASE WHEN (SELECT o.studentID FROM `tblonlinestudents` AS o WHERE o.studentID = e.studentID) ".
                    "IS NOT NULL ".
                    "THEN 1 ".
                    "ELSE 0 ".
                    "END) AS is_online ".
                    "FROM tblenrolled".$this->schoolTime." AS e INNER JOIN `tblstudentaccount` AS s ON e.studentID = s.studentID ".
                    "WHERE e.studentID = :searchID";
                $dataStmt = $this->db->prepare($dataQry);
                $dataStmt->execute(array(':searchID'=>$searchID));
                if($dataStmt->rowCount() == 1){
                    $studentData = $dataStmt->fetch(PDO::FETCH_ASSOC);
                    $enrol = "enrol";

                    echo json_encode(array($enrol,$studentData));
                }else{
                    try{
                        $findQry = "SELECT `studentID` , `lastName` , `firstName` , `middleName` FROM `tblstudentaccount` ".
                            "WHERE `studentID` = :id";
                        $findStmt = $this->db->prepare($findQry);
                        $findStmt->execute(array(':id'=>$searchID));
                        if($findStmt->rowCount() == 1){
                            $d = $findStmt->fetch(PDO::FETCH_ASSOC);
                            $acc = "acc";
                            //$found = 1;
                            echo json_encode(array($acc,$d));
                        }else
                        {
                            echo json_encode(array("none"));
                        }
                    }catch(PDOException $e){

                        echo $e->getMessage();
                    }
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function transactionHistory()
        {
            $IDtrans = $_POST['IDhist'];

            try
            {
                $transQry = "SELECT `compID` , `entryDate` , `logoutDate` , `consumedTime` , `consumedBal` FROM "
                    . "`tbldebit20163` WHERE `studentID` = :id "
                    . "UNION SELECT `compID` , `entryDate` , `logoutDate` , `consumedTime` , `consumedBal` FROM "
                    . "`tbldebit20171` WHERE `studentID` = :id "
                    . "UNION SELECT `compID` , `entryDate` , `logoutDate` , `consumedTime` , `consumedBal` FROM "
                    . "`tbldebit20172` WHERE `studentID` = :id "
                    . "UNION SELECT `compID` , `entryDate` , `logoutDate` , `consumedTime` , `consumedBal` FROM "
                    . "`tbldebit20173` WHERE `studentID` = :id ORDER BY `entryDate`";

                $transStmt = $this->db->prepare($transQry);
                $transStmt->execute([":id"=>$IDtrans]);
                $transList = $transStmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($transList);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }


        public function addToEnrolled(){
            $stdid = $_POST['studid'];

            try
            {
                $addQry = "INSERT INTO tblenrolled".$this->schoolTime." (`studentID`, `balance`) VALUES (:id, (10 + "
                    . "CASE WHEN (SELECT `balance` FROM `tblenrolled20172` WHERE `studentID` = :id) "
                    . "IS NOT NULL THEN (SELECT `balance` FROM `tblenrolled20172` WHERE `studentID` = :id) "
                    . "ELSE 0 END))";
                    

                // $addStmt = $this->db->prepare($addQry);
                $this->db->prepare($addQry)->execute([':id'=>$stdid]);
                //$addStmt->execute([':id'=>$stdid]);
                echo 1;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function loginStudent(){
            $stid = $_POST['id'];
            $comno = $_POST['compno'];
            date_default_timezone_set("Asia/Manila");
            $curDate = date('Y-m-d H:i:s');

            try
            {
                $loginQry = "INSERT INTO `tblonlinestudents` (`studentID` , `compID` , `entryDate`) VALUES(:id , :comno , :curDate)";

                //$loginStmt = $this->db->prepare($loginQry);
                $this->db->prepare($loginQry)->execute(array(':id'=>$stid , ':comno'=>$comno , ':curDate'=>$curDate));
                //$loginStmt->execute(array(':id'=>$stid , ':comno'=>$comno , ':curDate'=>$curDate));

                try
                {
                    $uptComp = "UPDATE `tblcomputer` SET `is_occupied` = 1 WHERE `compID` = :ucomno";

                    //$uptStmt = $this->db->prepare($uptComp);
                    $this->db->prepare($uptComp)->execute(array(':ucomno'=>$comno));
                    //$uptStmt->execute(array(':ucomno'=>$comno));
                    echo 1;
                }
                catch(PDOException $e)
                {
                    echo $e->getMessage();
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

        }

        public function studentLogInfo()
        {
            $stid = $_POST['studid'];

            try
            {
                $logsQry = "SELECT o.studentID , `compID` , `entryDate` , `lastName` , `firstName` , `middleName` , `balance` "
                    ."FROM `tblonlinestudents` AS o INNER JOIN tblenrolled".$this->schoolTime." as e ON e.studentID = o.studentID "
                    ."INNER JOIN `tblstudentaccount` AS s ON s.studentID =  e.studentID WHERE o.studentID = :sidd";
                $logStmt = $this->db->prepare($logsQry);
                $logStmt->execute(array(':sidd'=>$stid));

                $logInfo = $logStmt->fetch(PDO::FETCH_ASSOC);

                echo json_encode($logInfo);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        /**********************************************************************************************************************************/
        public function getOnlineStudents(){
            try
            {
                $onlineQry = "SELECT o.studentID , `compID` , `entryDate` , `lastName` , `firstName` , `middleName` , `balance` "
                    ."FROM `tblonlinestudents` AS o INNER JOIN tblenrolled".$this->schoolTime." as e ON e.studentID = o.studentID "
                    ."INNER JOIN `tblstudentaccount` AS s ON s.studentID =  e.studentID ORDER BY `entryDate` ASC";
                $onlineStmt = $this->db->prepare($onlineQry);
                $onlineStmt->execute();

                $onlinelist = $onlineStmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($onlinelist);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function getBalEntry()
        {
            try
            {
                $balentQry = "SELECT `balance` , `entryDate` FROM `tblonlinestudents` AS o INNER JOIN tblenrolled".$this->schoolTime." AS e "
                    ."ON e.studentID = o.studentID ORDER BY `entryDate` ASC";
                $balentStmt = $this->db->prepare($balentQry);
                $balentStmt->execute();
                $balent = $balentStmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($balent);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        /**********************************************************************************************************************************/
        public function logoutStudent()
        {
            $id = $_POST['sID'];
            $cid = $_POST['cID'];
            $entry = $_POST['entry'];
            $origB = $_POST['origB'];
            $cBal = $_POST['cBal'];
            $cTime = $_POST['cTime'];
            $rBal = $_POST['rBal'];
            $outTime = $_POST['outTime'];

            try
            {
                $delQry = "DELETE FROM `tblonlinestudents` WHERE `studentID` = :delID";
                $this->db->prepare($delQry)->execute(array('delID'=>$id));
                //$delStmt->execute(array('delID'=>$id));

                $insDebit = "INSERT INTO tbldebit".$this->schoolTime." (`studentID` , `compID` , `entryDate` , `logoutDate` , `consumedBal` , `consumedTime`) "
                    ."VALUES(:insID , :comID , :eDate , :lDate , :cBal , :cTime)";
                $this->db->prepare($insDebit)->execute(array('insID'=>$id,':comID'=>$cid,':eDate'=>$entry,':lDate'=>$outTime,':cBal'=>$cBal,':cTime'=>$cTime));
                //$insStmt->execute(array('insID'=>$id,':comID'=>$cid,':eDate'=>$entry,':lDate'=>$outTime,':cBal'=>$cBal,':cTime'=>$cTime));

                $lastID = $this->db->lastInsertId();

                $insCredit = "INSERT INTO tblcredit".$this->schoolTime." (`debitID` , `runningCredit` , `currentCredit`) "
                    ."VALUES(:lastID , :origB , :rBal)";
                $this->db->prepare($insCredit)->execute(array(":lastID"=>$lastID,":origB"=>$origB,":rBal"=>$rBal));
                // $creditStmt->execute(array(":lastID"=>$lastID,":origB"=>$origB,":rBal"=>$rBal));

                if($rBal > 0)
                {
                    $updBal = "UPDATE tblenrolled".$this->schoolTime." SET `balance` = :newB WHERE studentID = :updid";
                    $this->db->prepare($updBal)->execute(array(':newB'=>$rBal,':updid'=>$id));
                    // $updStmt->execute(array(':newB'=>$rBal,':updid'=>$id));
                }
                else
                {
                    $updBal = "UPDATE tblenrolled".$this->schoolTime." SET `balance` = :newB , `is_consumed` = 1 WHERE studentID = :updid";
                    $this->db->prepare($updBal)->execute(array(':newB'=>$rBal,':updid'=>$id));
                    //$updStmt->execute(array(':newB'=>$rBal,':updid'=>$id));
                }

                $updComp = "UPDATE `tblcomputer` SET `is_occupied` = 0 WHERE `compID` = :cID";
                $this->db->prepare($updComp)->execute(array(':cID'=>$cid));
                // $compStmt->execute(array(':cID'=>$cid));

                echo 1;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function fillComputer(){
            try{
                $fillQry = "SELECT `compID`,`compNum` FROM `tblcomputer` WHERE `is_occupied` = 0";
                $fillStmt = $this->db->prepare($fillQry);
                $fillStmt->execute();

                $option = "<option value=''></option>";

                while($row = $fillStmt->fetch(PDO::FETCH_ASSOC)){
                    $option .= "<option value='".$row['compID']."'>".$row['compNum']."</option>";
                }

                echo $option;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }






    }
?>