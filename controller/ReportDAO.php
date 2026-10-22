<?php
    class Report{
        private $db;

        function __construct($DB_con){
            $this->db = $DB_con;
        }

        public function transactionBySem()
        {
            $schYr = $_POST['schYr'];
            $sem = $_POST['Sem'];

            try
            {
                $bySemQry = "SELECT d.studentID , `lastName` , `firstName` , `middleName` , `consumedTime` , `currentCredit` "
                    ."FROM tblcredit".$schYr.$sem." AS c INNER JOIN tbldebit".$schYr.$sem." AS d "
                    ."ON c.debitID = d.debitID INNER JOIN `tblstudentaccount` AS s ON d.studentID = s.studentID";

                $bySemStmt = $this->db->prepare($bySemQry);
                $bySemStmt->execute();
                $result = $bySemStmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($result);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        public function transactionByDate()
        {
            $schYr = $_POST['schYr'];
            $sem = $_POST['Sem'];
            $date = $_POST['Date'];

            try
            {
                $bySemQry = "SELECT d.studentID , `lastName` , `firstName` , `middleName` , `consumedTime` , `currentCredit` "
                    ."FROM tblcredit".$schYr.$sem." AS c INNER JOIN tbldebit".$schYr.$sem." AS d "
                    ."ON c.debitID = d.debitID INNER JOIN `tblstudentaccount` AS s ON d.studentID = s.studentID WHERE d.entryDate LIKE '%$date%'" ;

                $bySemStmt = $this->db->prepare($bySemQry);
                $bySemStmt->execute();
                $result = $bySemStmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($result);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function transactionByID()
        {
            $schYr = $_POST['schYr'];
            $sem = $_POST['Sem'];
            $id = $_POST['ID'];

            try
            {
                $nameQry = "SELECT `lastName` , `firstName` , `middleName` FROM `tblstudentaccount` "
                    ."WHERE `studentID` = :id";
                $nameStmt = $this->db->prepare($nameQry);
                $nameStmt->execute(array(':id'=>$id));
                $nameInfo = $nameStmt->fetch(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

            try
            {
                $byIDQry = "SELECT `entryDate` , `logoutDate` , `consumedTime` , `currentCredit` "
                    ."FROM tblcredit".$schYr.$sem." AS c INNER JOIN tbldebit".$schYr.$sem." AS d "
                    ."ON c.debitID = d.debitID WHERE `studentID` = :byID";

                $byIDStmt = $this->db->prepare($byIDQry);
                $byIDStmt->execute(array(':byID'=>$id));
                $result = $byIDStmt->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

            echo json_encode(array($nameInfo,$result));
        }

    }
?>