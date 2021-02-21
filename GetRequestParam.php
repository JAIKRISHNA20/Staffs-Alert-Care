<?php
class Admin_View_Helper_GetRequestParam extends Zend_View_Helper_Abstract
{
	public function getRequestParam(){
        $front   = Zend_Controller_Front::getInstance(); 
        $request  = $front->getRequest();
		$req_arr = array('controller'=>$request->controller , 'action'=>$request->action);
		return $req_arr;
	}
}