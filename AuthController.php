<?php
class AuthController extends Zend_Controller_Action 
{
	protected $_redirector = null;
    
	public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');
		$this->_user = Default_Models_AdminAuth::getIdentity();
	    if($this->_user->userId)
        {
			$userType = $this->_user->userType;
			if($userType == 'A') {								
				$this->_redirector->gotoSimple('index','employees','admin');
				exit;
			} else {								
				$this->_redirector->gotoSimple('index','care','admin');
				exit;
			}
		}
	}

    public function indexAction() 
    {
		$request = $this->getRequest();
		$_POST = $request->getPost(); 
		$_GET = $request->getParams();
		
		$this->view->pageTitle = "Login";
		$form  = new Default_Form_Auth();
		if ($request->isPost()) {
			if ($form->isValid($_POST)) {
				$auth = new Default_Models_AdminAuth($_POST["useremail"],$_POST["password"]);
				if ($auth->authenticate()) {
					$this->_user = Default_Models_AdminAuth::getIdentity();
					 if($this->_user->userId)
					{
						$userType = $this->_user->userType;
						if($userType == 'A') {								
							$this->_redirector->gotoSimple('index','employees','admin');
							exit;
						} else {								
							$this->_redirector->gotoSimple('index','care','admin');
							exit;
						}
					}
					exit;
				} else {
					$this->view->errormessage = "Invalid username or password";
				}
            }
		}
        $this->view->form = $form;
        $this->view->msg = $_GET['msg'];
	}
}	
