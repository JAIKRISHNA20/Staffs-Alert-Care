<?php

class EmployeesController extends Zend_Controller_Action
{
	protected $_redirector = null;
	protected $_dbAdapter = null;
    
	public function init()
    {
		$registry = Zend_Registry::getInstance();
		$this->_dbAdapter = $registry->dbAdapter;
        $this->_redirector = $this->_helper->getHelper('Redirector');

        if (empty($this->view->adminidentity)) {
			$this->_redirector->gotoSimple('index','auth','admin');
			exit;
	    } 	
	}

    public function indexAction()
    {
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost(); 
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		
		#POST Process
		$searchTerm = '';
		if($this->getRequest()->isPost()) {
			#$searchTerm = trim($_POST['searchTerm']);
		}		
		
		#Getting employees list
		$employees =  $commonobj->getEmployees($searchTerm);
		
		#Setting data to view page
		$this->view->employees = $employees;
		$this->view->searchTerm = $searchTerm;
		$this->view->msg = $_GET['msg'];		
    }

    public function docslistAction()
    {
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost(); 
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		
		#POST Process
		$searchTerm = $where = '';
		if($this->getRequest()->isPost()) {
			#$searchTerm = trim($_POST['searchTerm']);
		}		
		
		#Getting employees list
		$where = " AND userid = '".$_GET['rowid']."' ";
		$docsfile =  $commonobj->getdocsfile($where);
		
		#Setting data to view page
		$this->view->docsfile = $docsfile;
		$this->view->userid = $_GET['rowid'];
		$this->view->searchTerm = $searchTerm;
		$this->view->msg = $_GET['msg'];		
    }
	
    public function notifylistAction()
    {
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost(); 
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		
		#POST Process
		$searchTerm = $where = '';
		if($this->getRequest()->isPost()) {
			#$searchTerm = trim($_POST['searchTerm']);
		}		
		
		#Getting employees list
		$where = " AND (userid = '' or userid is null) ";
		$docsfile =  $commonobj->getnotifications($where);
		
		#Setting data to view page
		$this->view->docsfile = $docsfile;
		$this->view->searchTerm = $searchTerm;
		$this->view->msg = $_GET['msg'];		
    }

    public function newAction()
    {	
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost();
		
		#Getting Objects
		$form    = new Default_Form_EmployeeForm();
		$commonobj = new Default_Models_Common();
		
		#variables
		$errormsg = '';
		
		#POST Process
		if($this->getRequest()->isPost()) {			
			if($form->isValid($request->getPost())){
				$info['username'] = trim($_POST['mobile']);
				$info['password'] = $commonobj->randomPassword();
				$_POST['adminid'] = $commonobj->insertAdminuser($info, 'U');
				$_POST['usercode'] = $info['username'];
				
				#Check for username exist
				$where = " AND (mobile LIKE '".trim($_POST['mobile'])."') ";
				if($commonobj->getEmployees($where)) {
					$errormsg = "Mobile already exist";
				} else {
					$insertData = new Default_Models_Employee($_POST);				
					$insertData->save();
					
					//Sendemail
					$emailinfo = array(
						"fromemail" => 'g.jaikrishna2000@gmail.com',
						"fromname" => 'Admin',
						"toemail" => $_POST['email'],# $this->view->testemail,#
						"subject" =>"Welcome to Employee Wellness Care",
						"texthtml" =>"Dear <strong>".$info['firstname'].' '.$info['lastname']."</strong>,<br><br>Your login details are <br><br>
												<strong>Login URL :</strong>".$this->view->httphost."auth/index<br>
												<strong>Username :</strong> ".$info['username']."<br>
												<strong>Password :</strong> ".$info['password']."<br><br>
												Regards,<br>
												<strong>Employee Wellness Care</strong>",
					 );
					$output = $commonobj->sendtestemail($emailinfo);
					
					$this->_redirector->gotoSimple('index','employees','admin',  array('msg' => 'Employee_added_successfully'));
				}
			}
		}
		
		#Setting data to view page
		$this->view->profileaction = "add";
		$this->view->form = $form;
		$this->view->errormsg = $errormsg;
    }	
	
	public function editAction()
	{
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost();
		
		#Getting Objects
		$form    = new Default_Form_EmployeeForm();
		$users = new Default_Models_Employee();
		$commonobj = new Default_Models_Common();
		
		#Getting users info
		$row =  $users->find($_GET['rowid']);
		
		#variables
		$errormsg = '';		
		
		#POST Process
		if($this->getRequest()->isPost()) {
			if($form->isValid($request->getPost())){
				$_POST['adminid'] = $row->adminid;
				$_POST['usercode'] = $row->usercode;
				//echo "<pre>"; print_r($_POST); exit;
				#Check for username exist
				$where = " AND mobile LIKE '".trim($_POST['mobile'])."' AND uid != ".$_POST['uid'];
				if($commonobj->getEmployees($where)) {
					$errormsg = "Mobile already exist";
				} else {
					$insertData = new Default_Models_Employee($_POST);
					$insertData->save();				
					$this->_redirector->gotoSimple('index','employees','admin', array('msg' => 'Updated_Successfully'));
				}
			}
		}
		
		#Setting data to view page
		$this->view->row = $row;	
		$this->view->form = $form;		
		$this->view->profileaction = "edit";
		$this->view->errormsg = $errormsg;
	}
	
	public function historyAction()
	{
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost(); 
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		
		$where = " AND userid = '".$_GET['rowid']."'";
		$wellnessinfo = $commonobj->getwellness($where);
		
		#Setting data to view page
		$this->view->msg = $_GET['msg'];		
		$this->view->wellnessinfo = $wellnessinfo;	
	}
		
    public function statusAction()
    {
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost(); 
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		
		$IsSick = rand(1,2);
		$wellnessinfo = $commonobj->getwellnessdata($IsSick);
		$wellnessinfo['userid'] = $_GET['rowid'];
		$commonobj->insertwellness($wellnessinfo);
		
		#Setting data to view page
		$this->view->msg = $_GET['msg'];		
		$this->view->wellnessinfo = $commonobj->getwellnessMessage($wellnessinfo);
		$this->view->employeesinfo = $commonobj->getEmployees(" AND adminid = '".$_GET['rowid']."'");
    }

    public function updatestatusAction()
    {
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost(); 
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		$IsSick = rand(1,2);
		$wellnessinfo = $commonobj->getwellnessdata($IsSick);
		
		$wellnessinfo['userid'] = $_GET['rowid'];
		$commonobj->insertwellness($wellnessinfo);
		
		$wellnessinfo = $commonobj->getwellnessMessage($wellnessinfo);
		echo json_encode($wellnessinfo);
		exit;
    }	
	
	public function deleteAction(){
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost(); 
		
		#Disable layout
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		if(isset($_GET['rowid']) && $_GET['rowid'] != ""){
			#Getting Objects
			$commonobj = new Default_Models_Common();
			$users = new Default_Models_Employee();
			$row =  $users->find($_GET['rowid']);
			
			#Getting users list
			$commonobj->deleteEmployee($_GET['rowid'], $row->adminid);
			$this->_redirector->gotoSimple('index','users','admin', array('msg' => 'Deleted_Successfully'));
		}
		echo "<br>==========>RowId Not Found";
		exit;	
		
	}	
	
	 public function docsAction()
    {	
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost();
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		
		#variables
		$errormsg = '';
		$info = array();
		
		#POST Process
		if($this->getRequest()->isPost()) {	
			$info = $_POST;	
			$info['upfile'] = '';
			if($_FILES["imagepath"]["error"] == 1) {
				$errormsg = "Error in image try another image";
			}
			if(!empty($_FILES["imagepath"]["tmp_name"])) {
				#Image Storing
				$target_filename = date('YmdHis').'_'.rand(100,999).".png";
				$target_path = $this->view->uploadpath.'/category/'.$target_filename;
				$imageFileType = $_FILES['imagepath']['type'];
				//echo "<pre>"; print_r($_FILES); exit;
				#Check file size
				if ($_FILES["imagepath"]["error"] == 1) {
					$errormsg = "Error in image try another image";
				} else if ($_FILES["imagepath"]["size"] > 500000) {
					$errormsg = "Sorry, your file is too large";
				} else if($imageFileType != "image/png" && $imageFileType != "image/jpeg" && $imageFileType != "image/jpg" ) {
					$errormsg = "Sorry, only JPG, JPEG & PNG files are allowed";
				} else {
					if (move_uploaded_file($_FILES["imagepath"]["tmp_name"], $target_path)) {
						$info['upfile'] = $target_filename;
					} else {	
						$errormsg = "Sorry, there was an error uploading your file";
					}
				}
			} else {
				$errormsg = "Upload file before submit";
			}
			if(empty($errormsg)) {
				$info['userid'] = $_GET['rowid'];
				if($commonobj->insertdocsfile($info)) {
					$this->_redirector->gotoSimple('docslist','employees','admin',  array('rowid' => $_GET['rowid'], 'msg' => 'File_added_successfully'));
				} else {
					$errormsg = "Error in category create";
				}
			}
		}
		
		#Setting data to view page
		$this->view->profileaction = "add";
		$this->view->errormsg = $errormsg;
		$this->view->info = $info;
    }
	 public function notifyAction()
    {	
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost();
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		
		#variables
		$errormsg = '';
		$info = array();
		
		#POST Process
		if($this->getRequest()->isPost()) {	
			$info = $_POST;	
			$info['upfile'] = '';
			if($_FILES["imagepath"]["error"] == 1) {
				$errormsg = "Error in image try another image";
			}
			if(!empty($_FILES["imagepath"]["tmp_name"])) {
				#Image Storing
				$target_filename = date('YmdHis').'_'.rand(100,999).".png";
				$target_path = $this->view->uploadpath.'/category/'.$target_filename;
				$imageFileType = $_FILES['imagepath']['type'];
				//echo "<pre>"; print_r($_FILES); exit;
				#Check file size
				if ($_FILES["imagepath"]["error"] == 1) {
					$errormsg = "Error in image try another image";
				} else if ($_FILES["imagepath"]["size"] > 500000) {
					$errormsg = "Sorry, your file is too large";
				} else if($imageFileType != "image/png" && $imageFileType != "image/jpeg" && $imageFileType != "image/jpg" ) {
					$errormsg = "Sorry, only JPG, JPEG & PNG files are allowed";
				} else {
					if (move_uploaded_file($_FILES["imagepath"]["tmp_name"], $target_path)) {
						$info['upfile'] = $target_filename;
					} else {	
						$errormsg = "Sorry, there was an error uploading your file";
					}
				}
			}
			
			if(empty($errormsg)) {
				/*$employees =  $commonobj->getEmployees();
				foreach($employees as $emp) {
					$info['userid'] = $emp->adminid;
					$info['ntype'] = 1;
					$commonobj->insertnotifications($info);
				}*/
				$info['userid'] = '';
				$info['ntype'] = 1;
				$commonobj->insertnotifications($info);
				$this->_redirector->gotoSimple('notifylist','employees','admin',  array('msg' => 'Notify_added_successfully'));
			}
		}
		
		#Setting data to view page
		$this->view->profileaction = "add";
		$this->view->errormsg = $errormsg;
		$this->view->info = $info;
    }
}