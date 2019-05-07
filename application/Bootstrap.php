<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAutoload(){
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
        'namespace' => '', 
        'basePath' => APPLICATION_PATH));
        
        return $moduleLoader;
    }

    protected function _initRestRoute()
	{
		$this->bootstrap('Request');	
		$front = $this->getResource('FrontController');
		$restRoute = new Zend_Rest_Route($front, array(), array(
			'default' => array('sinactividad5igo')
		));
		$front->getRouter()->addRoute('rest', $restRoute);
	} 

	protected function _initRequest()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = $front->getRequest();
    	if (null === $front->getRequest()) {
            $request = new Zend_Controller_Request_Http();
            $front->setRequest($request);
        }
    	return $request;        
    } 	
}

