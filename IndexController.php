<?php

class IndexController extends Zend_Controller_Action
{
	protected $_redirector = null;
	protected $_dbAdapter = null;
    
	public function init()
    {
		$registry = Zend_Registry::getInstance();
		$this->_dbAdapter = $registry->dbAdapter;
        $this->_redirector = $this->_helper->getHelper('Redirector');
	}

    public function indexAction()
    {
		$this->_redirector->gotoSimple('index','auth','admin');
    }

    public function logoutAction()
    {
		Default_Models_AdminAuth::destroy();
		$this->_redirector->gotoSimple('index','auth','admin');
		exit;
    }
}