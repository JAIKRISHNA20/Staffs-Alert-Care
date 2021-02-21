<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
    {
		$this->bootstrap('view');
        $view = $this->getResource('view');
		ZendX_JQuery::enableView($view);
		$view->setEscape('stripslashes');
        $view->doctype('XHTML1_TRANSITIONAL');
		$view->adminidentity = $this->_initAdminAuth();
		if($_SERVER['HTTP_HOST'] == 'localhost') {
   		$view->httphost = ""; 
		} else  {
   		$view->httphost = "";
		}

   		$view->httphost = "http://myshop.tripletechsoft.org/employeewellness/";
   		$view->testemail = "ihjeeva@gmail.com";
		$view->uploadpath = "G:/PleskVhosts/tripletechsoft.in/myshop.tripletechsoft.org/chatshopadmin/html/images";
		$view->uphttphost = "http://myshop.tripletechsoft.org/chatshopadmin/";		
		$registry = Zend_Registry::getInstance();
		$registry->view = $view;		
    }

	protected function _initDb()
    {
		$resource = $this->getPluginResource('multidb');
		$resource->init();
		$db = $resource->getDb('db1');
		$registry = Zend_Registry::getInstance();
		$registry->externaldbAdapter = $db;
    }


	protected function _initAdminAuth(){
		$identity = Default_Models_AdminAuth::getIdentity();
        if ($identity && is_numeric($identity->userId) && $identity->userId > 0){
               return $identity;
         }
		 return false;
	}



}
