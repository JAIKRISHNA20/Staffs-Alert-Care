<?php
class Default_View_Helper_GetNav extends Zend_View_Helper_Abstract
{
    public function getNav()
    {
        $front   = Zend_Controller_Front::getInstance(); 
        $request  = $front->getRequest();
		$nav_arr = array('controller'=>$request->controller , 'action'=>$request->action);
		return $nav_arr;
    }
}
