<?php

class Default_Models_Common extends Zend_Db_Table_Abstract
{
	protected $_name;
	protected $_db;
	
	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	
	public function insertAdminuser($info, $type){
		$this->_db = $this->getAdapter();
		$this->_db->setFetchMode(PDO::FETCH_OBJ);
		$sql = "INSERT INTO `adminusers` (`userName`, `userPassword`, `userType`, `userStatus`, orgpassword) VALUES ( '".strtolower($info['username'])."', '".md5($info['password'])."', '".$type."', '1', '".$info['password']."')";
		$bind = array();
		$this->_db->query($sql,$bind);
		return $this->_db->lastInsertId();
	} 
	
	public function getEmployees($where = ''){
  	    $this->_db = $this->getAdapter();
	    $this->_db->setFetchMode(PDO::FETCH_OBJ);
		$sql = "select u.*, a.userName from employees u 
					LEFT JOIN adminusers a ON (a.userId = u.adminid)
					where 1=1 ".$where;
		// echo $sql; exit;
		$bind = array();
		$res = $this->_db->fetchAll($sql,$bind);
		return $res;
	}
	
	public function deleteEmployee($id, $adminid){
		$this->_db = $this->getAdapter();
		$this->_db->setFetchMode(PDO::FETCH_OBJ);
		
		#delete user
		$sql = "delete from employees where uid = ? ";
		$bind = array($id);
		$this->_db->query($sql,$bind);
		
		#delete login
		$sql = "delete from adminusers where userId = ? ";
		$bind = array($adminid);
		$this->_db->query($sql,$bind);
	} 
	
	public function sendtestemail($emailinfo){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://myproject.org.in/employeecare/auth/index/msg/1");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8;"));
		$data = json_encode ($emailinfo);
		curl_setopt($ch, CURLOPT_POST, $data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		//Actual Call to Server
		$server_output = curl_exec($ch);
		curl_close($ch);
		return $server_output;
	 }
	 
	 
	public function insertwellness($info){
		$this->_db = $this->getAdapter();
		$this->_db->setFetchMode(PDO::FETCH_OBJ);
		$sql = "INSERT INTO `wellness` (`userid`, `bodytemp`, `bp1`, `bp2`, `Glucose`, `hartrate`, `oxygen`, `created`) VALUES ( '".$info['userid']."', '".$info['bodytemp']."', '".$info['bp1']."', '".$info['bp2']."', '".$info['Glucose']."', '".$info['hartrate']."', '".$info['oxygen']."', '".date('Y-m-d H:i:s')."')";
		$bind = array();
		$this->_db->query($sql,$bind);
		return $this->_db->lastInsertId();
	} 
	 	 
	public function getwellness($where = ''){
		$this->_db = $this->getAdapter();
	    $this->_db->setFetchMode(PDO::FETCH_OBJ);
		$sql = "select * from wellness where 1=1 ".$where." Order by created desc";
		#echo $sql; exit;
		$bind = array();
		$res = $this->_db->fetchAll($sql,$bind);
		return $res;
	} 
	
	public function insertdocsfile($info){
		$this->_db = $this->getAdapter();
		$this->_db->setFetchMode(PDO::FETCH_OBJ);
		$sql = "INSERT INTO `docsfile` (`userid`, upfile, `content`, `created`) VALUES ('".$info['userid']."',  '".$info['upfile']."', '".addslashes($info['content'])."', '".date('Y-m-d H:i:s')."');";
		#echo $sql; exit;
		$bind = array();
		$this->_db->query($sql,$bind);
		return $this->_db->lastInsertId();
	} 
	 	 
	public function getdocsfile($where = ''){
		$this->_db = $this->getAdapter();
	    $this->_db->setFetchMode(PDO::FETCH_OBJ);
		$sql = "select * from docsfile where 1=1 ".$where." Order by created desc";
		#echo $sql; exit;
		$bind = array();
		$res = $this->_db->fetchAll($sql,$bind);
		return $res;
	} 
	
	public function insertnotifications($info){
		$this->_db = $this->getAdapter();
		$this->_db->setFetchMode(PDO::FETCH_OBJ);
		$sql = "INSERT INTO `notifications` (`userid`, upfile, `content`, readstatus,`created`) VALUES ('".$info['userid']."',  '".$info['upfile']."', '".addslashes($info['content'])."', '', '".date('Y-m-d H:i:s')."');";
		$bind = array();
		$this->_db->query($sql,$bind);
		return $this->_db->lastInsertId();
	} 
	 	 
	public function getnotifications($where = ''){
		$this->_db = $this->getAdapter();
	    $this->_db->setFetchMode(PDO::FETCH_OBJ);
		$sql = "select * from notifications where 1=1 ".$where." Order by created desc";
		#echo $sql; exit;
		$bind = array();
		$res = $this->_db->fetchAll($sql,$bind);
		return $res;
	} 
	
	public function getwellnessdata($IsSick){
		if($IsSick == 1){
			$bodytemparr = array(91,93,94.5,99.7,100.1,100.5, 100.6,101,101.4,101.7,102.2,102.8,103.5,);
			$bp1arr = array(81,83,89,87,79,125,133,139,143,182,177,199);
			$bp2arr = array(51,53,59,57,49,85,87,89,93,97,99,100);
			$Glucosearr = array(77,71,75,60,65,50,145,153,149,160,180,193,200);
			$hartratearr = array(93,95,97,102,107,113,101,163,167,169,175,177,180);
			$oxygenarr = array(81,83,89,87,79, 91,93,94.5);
		} else {			
			$bodytemparr = array(97.7, 97.9, 98.1, 98.3, 98.5, 98.8, 99, 99.1, 99.4);
			$bp1arr = array(90, 93, 97, 99, 103, 108, 111, 114, 117, 119);
			$bp2arr = array(60, 63, 67, 69, 72, 75, 79, 77, 80);
			$Glucosearr = array(81,83,89,87,79,125,133,139, 102,107,113,101);
			$hartratearr = array(120, 160, 133, 122, 128, 139, 137, 125, 127);
			$oxygenarr = array(95,96,97,98,99,100);
		}
		return array(
				"bodytemp" => $bodytemparr[array_rand($bodytemparr)],
				"bp1" => $bp1arr[array_rand($bp1arr)],
				"bp2" => $bp2arr[array_rand($bp2arr)],
				"Glucose" => $Glucosearr[array_rand($Glucosearr)],
				"hartrate" => $hartratearr[array_rand($hartratearr)],
				"oxygen" => $oxygenarr[array_rand($oxygenarr)],
			);
	}
	
	
	public function getwellnessMessage($wellnessinfo){
		$infomsg = array();
		
		$bodytemp = '';
		if($wellnessinfo['bodytemp'] <= 96) {
			$bodytemp .= "Hypothermia";
		} else if($wellnessinfo['bodytemp'] >= 99.5 && $wellnessinfo['bodytemp'] <= 100.9) { 
			$bodytemp .=  "Fever";
		} else if($wellnessinfo['bodytemp'] >= 101 && $wellnessinfo['bodytemp'] <= 103.9) { 
			$bodytemp .=  "Hyperthermia";
		} else if($wellnessinfo['bodytemp'] >= 104) { 
			$bodytemp .=  "Hyperpyrexia";
		} else { 
			$bodytemp .=  "Normal";
		} 
		$bodytemp .=  "(".$wellnessinfo['bodytemp']."'F)";
		
		$bp1 = '';
		if($wellnessinfo['bp1'] <= 90  || $wellnessinfo['bp2'] <= 60) {
			$bp1 .= "Low";
		} else if(($wellnessinfo['bp1'] >= 120 && $wellnessinfo['bp1'] <= 140)  || ($wellnessinfo['bp2'] >= 80 && $wellnessinfo['bp2'] <= 90)) {
			$bp1 .= "Pre high";
		} else if($wellnessinfo['bp1'] >= 140  || $wellnessinfo['bp2'] >= 90) {
			$bp1 .= "High";
		} else {
			$bp1 .= "Normal";
		}
		$bp1 .= " BP(".$wellnessinfo['bp1']."/".$wellnessinfo['bp2'].")";
		
		$Glucose = '';
		if($wellnessinfo['Glucose'] <= 80) {
			$Glucose .=  "Low";
		} else if($wellnessinfo['Glucose'] >= 141 && $wellnessinfo['Glucose'] <= 199) { 
			$Glucose .= "Pre Diabetes";
		} else if($wellnessinfo['Glucose'] >= 200) { 
			$Glucose .= "Diabetes";
		} else { 
			$Glucose .= "Normal";
		} 
		$Glucose .= "(".$wellnessinfo['Glucose']."mg/dl)";
		
		$hartrate = '';
		if($wellnessinfo['hartrate'] <= 120) {
			$hartrate .=  "Low Rate";
		} else if($wellnessinfo['hartrate'] >= 161) { 
			$hartrate .=  "High Rate";
		} else { 
			$hartrate .=  "Normal Rate";
		} 
		$hartrate .=  "(".$wellnessinfo['hartrate']." per min)";
		
		$oxygen = '';
		if($wellnessinfo['oxygen'] <= 90) {
			$oxygen .= "Strongly Consult Doctor";
		} else if($wellnessinfo['oxygen'] >= 91 && $wellnessinfo['oxygen'] <= 95) { 
			$oxygen .= "Consult Doctor";
		} else { 
			$oxygen .= "Normal";
		} 
		$oxygen .= "(".$wellnessinfo['oxygen']."%)";
		
		return array(
				"bodytemp" => $bodytemp,
				"bp1" => $bp1,
				"Glucose" => $Glucose,
				"hartrate" => $hartrate,
				"oxygen" => $oxygen,
			);
	}
	
}
?>