<?php
	class Login{
		private $db;
		
		function __construct($DB_con){
			$this->db = $DB_con;
		}

		public function isLoggedIn(){
			if(isset($_SESSION['user_session'])){
				return true;
			}
			return false;
		}
		
		public function doLogin($name, $pass){
			try{
				$sql = "SELECT * FROM users WHERE username=:uname && password=:upass";
				$stmt = $this->db->prepare($sql);
			//	$stmt->execute(array(':uname'=>$name, ':upass'=>substr($this->password($pass),0,20)));
				$stmt->execute(array(':uname'=>$name, ':upass'=>$pass));
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount() == 1){
					$_SESSION['user_session'] = $userRow['id'];
					return true;
				}else {
					return false;
				}
			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}
		
		public function doLogout(){
			session_destroy();
			unset($_SESSION['user_session']);
			return true;
		}
		
		public function getUser($user_id){
			$query="SELECT * FROM users WHERE id=:user_id";
			$stmt = $this->db->prepare($query);
			$stmt->bindparam(":user_id", $user_id);
			$stmt->execute();
			if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				return $row['username'];
			}
		}
		

		public function closeConnection(){
            try {
                $this->conn = null;
            } catch (Exception $e) {
                $e->getMessage();
            }
        }

	}
?>