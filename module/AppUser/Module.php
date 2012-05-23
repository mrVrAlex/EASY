<?php

namespace AppUser;

use
    Zend\Config\Config,
    Zend\ModuleManager\ModuleManager,
    Zend\Loader\AutoloaderFactory,
    Zend\EventManager\StaticEventManager;

class Module
{
    protected $authPlugin = null;
    
    public function init(ModuleManager $moduleManager)
    {
        $events       = $moduleManager->events();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach('bootstrap', 'bootstrap', array($this, 'initializePlugins'), 101);
        //$sharedEvents->attach('Zend\Mvc\Application','route', array($this, 'postRoute'), 1);
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return new Config(include __DIR__ . '/config/module.config.php');
    }

    public function initializePlugins($e)
    {
        $locator = $e->getParam('application')->getLocator();
        //@TODO clean refactoring when ZF2.0 releaze
        //\Zend\Registry::set('locator',$locator);
        $this->authPlugin = $locator->get('AppUser\Plugin\Auth');
        $this->authPlugin->setApplication($e->getParam('application'));
	    //\Zend\Db\Table\AbstractTable::setDefaultAdapter($locator->get('Zend\Db\Adapter\PdoMysql'));
        //\Zend\View\HelperLoader

        //$view = $locator->get('view');
        //$view->setBroker($locator->get('Zend\View\HelperBroker'));
        //$broker = $view->getBroker();
        //$loader = $broker->getClassLoader();
       // $helper = new View\Helper\UserInfo();
        //$loader->registerPlugin('userInfo',  'AppUser\View\Helper\UserInfo');

	
    }

    public function postRoute(\Zend\EventManager\Event $e)
    {
        $this->authPlugin->routeShutdown($e);
    }
}
