<?php

class CareController extends Zend_Controller_Action
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
		
		$IsSick = rand(1,2);
		$wellnessinfo = $commonobj->getwellnessdata($IsSick);
		$wellnessinfo['userid'] = $this->view->adminidentity->userId;
		$commonobj->insertwellness($wellnessinfo);
		
		#Setting data to view page
		$this->view->msg = $_GET['msg'];		
		$this->view->wellnessinfo = $commonobj->getwellnessMessage($wellnessinfo);
		$this->view->employeesinfo = $commonobj->getEmployees(" AND adminid = '".$this->view->adminidentity->userId."'");		
    }	
	
    public function historyAction()
    {
		#Getting Request Info
		$request = $this->getRequest();
		$_GET = $request->getParams();
		$_POST = $request->getPost(); 
		
		#Getting Objects
		$commonobj = new Default_Models_Common();
		
		$where = " AND userid = '".$this->view->adminidentity->userId."'";
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
		
		$wellnessinfo['userid'] = $this->view->adminidentity->userId;
		$commonobj->insertwellness($wellnessinfo);
		
		$wellnessinfo = $commonobj->getwellnessMessage($wellnessinfo);
		echo json_encode($wellnessinfo);
		exit;
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
		$where = " AND userid = '".$this->view->adminidentity->userId."' ";
		$docsfile =  $commonobj->getdocsfile($where);
		
		#Setting data to view page
		$this->view->docsfile = $docsfile;
		$this->view->userid = $this->view->adminidentity->userId;
		$this->view->searchTerm = $searchTerm;
		$this->view->msg = $_GET['msg'];		
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
				$info['userid'] = $this->view->adminidentity->userId;
				if($commonobj->insertdocsfile($info)) {
					$this->_redirector->gotoSimple('docslist','care','admin',  array('msg' => 'File_added_successfully'));
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
}