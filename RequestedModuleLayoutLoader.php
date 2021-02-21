<?php
class Default_Controller_Plugin_RequestedModuleLayoutLoader
    extends Zend_Controller_plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $config     = Zend_Controller_Front::getInstance()
                            ->getParam('bootstrap')->getOptions();
        $moduleName = $request->getModuleName();
		$obj = new Zend_Layout(null,true);
		if (isset($config[$moduleName]['resources']['layout']['layout'])) {
            $layoutScript = $config[$moduleName]['resources']['layout']['layout'];
            $obj->setLayout($layoutScript);
        }
        if (isset($config[$moduleName]['resources']['layout']['layoutPath'])) {
            $layoutPath = $config[$moduleName]['resources']['layout']['layoutPath'];
			$moduleDir = Zend_Controller_Front::getInstance()->getModuleDirectory();
			$obj->setLayoutPath(
                $moduleDir. DIRECTORY_SEPARATOR .$layoutPath
            );
        }
    }
}