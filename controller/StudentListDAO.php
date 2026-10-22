<?php
    class Student{
        private $db;

        function __construct($DB_con){
            $this->db = $DB_con;
        }

        public function getStudentList(){
            // echo $navAction;
            $rowsPerPage = $_POST['rowsPerPage'];
            $currentPage = $_POST['currentPage'];

            $searchOption = $_POST['searchOption'];
            $tblCol = $_POST['tblCol'];
            $navAction = $_POST['navAction'];
            $searchKeyword = "%".$_POST['keyword']."%";
            $sql_condition = 'WHERE';
            $orderby = 'accountID';

            if($searchKeyword<>''){
                $sql_condition.= ($sql_condition=='WHERE'?'':' AND')." ($searchOption LIKE ?)";//'%$keyword%'
            }
            if($sql_condition=='WHERE'){
                $sql_condition = '';
            }
            //Work with total page
            try
            {
                $listQuery = "SELECT s.studentID , `lastName` , `firstName` " . //  , `middleName`, `gender` ,
                    //"IFNULL((SELECT `balance` FROM `tblenrolled20171` AS e WHERE e.studentID = s.studentID), 0) AS bal ".
                    "FROM `tblstudentaccount` AS s $sql_condition ORDER BY s"."."."$orderby ASC";

                $stmt = $this->db->prepare($listQuery);
                $stmt->bindparam(1,$searchKeyword);
                $stmt->execute();
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

            $totalRow = $stmt->rowCount();
            $totalPages = ceil($totalRow/$rowsPerPage);

            if($totalRow%$rowsPerPage>0)
            {
                $totalPages = ceil($totalRow/$rowsPerPage);
            }

            $targetPage = 1;
            $nav_btn_disable = array();

            if($navAction=='first'){
                $targetPage = 1;
                $currentPage = $targetPage;
            }elseif($navAction=='prev'){
                //$targetPage = $currentPage-1;
                $currentPage = $currentPage - 1;
                $targetPage = $currentPage;

            }elseif($navAction=='next'){
                $currentPage++;
                $targetPage = $currentPage;
            }elseif($navAction=='last'){
                $targetPage = $totalPages;
                $currentPage = $totalPages;
            }elseif($navAction=='goto'){
                $targetPage = $currentPage;
            }

            $gotoSelectNum = array();
            for($i=1;$i<=$totalPages;$i++){
                $gotoSelectNum[] = $i;
            }

            if($totalPages==1 || $totalPages==0){
                $nav_btn_disable = array('nav_first'=>0,'nav_prev'=>0,'nav_next'=>0,'nav_last'=>0);
            }elseif($targetPage==1){
                $nav_btn_disable = array('nav_first'=>0,'nav_prev'=>0,'nav_next'=>1,'nav_last'=>1);
            }elseif($targetPage==$totalPages){
                $nav_btn_disable = array('nav_first'=>1,'nav_prev'=>1,'nav_next'=>0,'nav_last'=>0);
            }else{
                $nav_btn_disable = array('nav_first'=>1,'nav_prev'=>1,'nav_next'=>1,'nav_last'=>1);
            }


            $startIndex = ($targetPage-1)*$rowsPerPage;
            $dataListString = '';
            $i=$startIndex+1;

            try
            {
                $dataQry = "SELECT s.studentID , `lastName` , `firstName` , `middleName`, `gender` , " .
                    "IFNULL((SELECT `balance` FROM `tblenrolled20173` AS e WHERE e.studentID = s.studentID), 0) AS bal " .
                    "FROM `tblstudentaccount` AS s $sql_condition ORDER BY s"."."."$orderby ASC LIMIT ".$startIndex." , $rowsPerPage";
                $qryStmt = $this->db->prepare($dataQry);
                $qryStmt->bindparam(1 , $searchKeyword);
                $qryStmt->execute();
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

            // if($rowsPerPage == 20){
            // 	$currentPage = ;
            // }elseif($rowsPerPage == 30){
            // 	$currentPage = 1;
            // }

            $ctr = $rowsPerPage*($currentPage-1);

            while ($row = $qryStmt->fetch(PDO::FETCH_ASSOC)) {
                $ctr++;
                $dataListString .= '<tr>
                     	 								<td>'.$ctr.'</td>
                     	 								<td>'.$row['lastName'].'</td>
                     	 								<td>'.$row['firstName'].'</td>
                     	 								<td>'.$row['middleName'].'</td>
                     	 								<td>'.$row['studentID'].'</td>
                     	 								<td>'.$row['bal'].'</td>
                     	 								<td>
                     	 									  <div class="btn-group">
                                                          <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                &nbsp;Action&nbsp;&nbsp;
                                                                <span class="fa fa-caret-down fa-md"></span>
                                                          </button>
                                                              <ul class="dropdown-menu">
                                                                  <li>
                                                                  	<a href="Javascript:void(0)" class="dropdown-item" id="btnEdit" data-std="'.$row['studentID'].'" data-toggle="modal" data-target="#edit-modal">
                                                                  		<i class="fa fa-pencil-square-o fa-lg"></i>&nbsp;Edit
                                                                  	</a>
                                                                  </li>
                                                                  <li>
                                                                  	<a href="Javascript:void(0)" class="dropdown-item" id="btnDelete" data-studid="'.$row['studentID'].'" data-toggle="modal" data-target="#confirmDel">
                                                                  		<i class="fa fa-trash fa-lg"></i>&nbsp;Delete
                                                                  	</a>
                                                                  </li>
                                                              </ul>
                                          </div>
             	 								        </td>
           	 							          </tr>';
                $i++;
            }

            if($dataListString == ''){
                $dataListString = '<tr><td colspan="'.$tblCol.'" style="text-align:center; color:#c0434d;"><i class="fa fa-frown-o"></i> No Data Found</td></tr>';
            }

            $data = array('list'=>$dataListString,'targetPage'=>$targetPage,'totalPages'=>$totalPages,'gotoSelectNum'=>$gotoSelectNum,'nav_btn_disable'=>$nav_btn_disable);

            echo json_encode($data);
        }
        //end showListFunction

        public function addStudent()
        {
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $studid= $_POST['studid'];
            $gender = $_POST['gender'];


            try
            {
                $addSAcc = "INSERT INTO `tblstudentaccount` (`studentID`,`lastName`,`firstName`,`middleName`,`gender`) VALUES (:studid,:lname,:fname,:mname,:gender)";
                //$addStmt =
                $this->db->prepare($addSAcc)->execute(array(':studid'=>$studid,':lname'=>$lname,':fname'=>$fname,':mname'=>$mname,':gender'=>$gender));
                //$addStmt->execute(array(':studid'=>$studid,':lname'=>$lname,':fname'=>$fname,':mname'=>$mname,':gender'=>$gender));
                $acc = 1;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

            try
            {
                $addInEnrolled = "INSERT INTO `tblenrolled20173` (`studentID`) VALUES (:stdid)";
                //$addInEStmt = $this->db->prepare($addInEnrolled);
                $this->db->prepare($addInEnrolled)->execute(array(':stdid'=>$studid));
                //$addInEStmt->execute(array(':stdid'=>$studid));
                $enrol = 1;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

            $good = array($acc,$enrol);

            echo json_encode($good);
        }

        public function getStudentInfo()
        {
            $id = $_POST['sID'];

            try
            {
                $infoQry = "SELECT s.studentID , `lastName` , `firstName` , `middleName` , `gender` , ".
                    "IFNULL((SELECT `balance` FROM `tblenrolled20173` AS e WHERE e.studentID = :sid),0) ".
                    "AS bal FROM `tblstudentaccount` AS s WHERE s.studentID = :sid";
                $infoStmt = $this->db->prepare($infoQry);
                $infoStmt->execute(array(':sid'=>$id));
                $studentInfo = $infoStmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($studentInfo);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function updateStudentInfo()
        {
            $eid = $_POST['vid'];
            $lname = $_POST['elname'];
            $fname = $_POST['efname'];
            $mname = $_POST['emname'];
            $studnum = $_POST['estudnum'];
            $gender = $_POST['egender'];


            try{
                $updateQry = "UPDATE `tblstudentaccount` SET `studentID` = :estudnum, " .
                    "`lastName` = :elname, `firstName` = :efname, `middleName` = :emname, " .
                    "`gender` = :egender WHERE `studentID` = :evid";

                //$updateStmt = $this->db->prepare($updateQry);
                $this->db->prepare($updateQry)->execute(array(':estudnum'=>$studnum,':elname'=>$lname,':efname'=>$fname,':emname'=>$mname,':egender'=>$gender,':evid'=>$eid));
                //$updateStmt->execute(array(':estudnum'=>$studnum,':elname'=>$lname,':efname'=>$fname,':emname'=>$mname,':egender'=>$gender,':evid'=>$eid));
                echo 1;


            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function deleteStudent()
        {
            $id = $_POST['studID'];

            try
            {
                $delQry = "DELETE FROM `tblstudentaccount` WHERE `studentID` = :id";
                $this->db->prepare($delQry)->execute([':id'=>$id]);
                echo 1;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    }

?>