<?php

class RegisterController extends Zend_Controller_Action
{
	protected $_redirector = null;
	protected $_dbAdapter = null;
    
	public function init()
    {
		$registry = Zend_Registry::getInstance();
		$this->_dbAdapter = $registry->dbAdapter;
        $this->_redirector = $this->_helper->getHelper('Redirector');

        if (!empty($this->view->adminidentity)) {
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
						"fromemail" => 'ihjeeva@gmail.com',
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
					
					$this->_redirector->gotoSimple('index','auth','admin',  array('msg' => '1'));
				}
			}
		}
		
		#Setting data to view page
		$this->view->profileaction = "add";
		$this->view->form = $form;
		$this->view->errormsg = $errormsg;
    }
}