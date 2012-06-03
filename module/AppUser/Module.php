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
        $sharedEvents->attach('Zend\Mvc\Application','route', array($this, 'postRoute'), 1);
    }

    public function onBootstrap($e){
        $this->initializePlugins($e);
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

    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'auth-plugin' => function ($sm) {
                    $di = $sm->get('Di');
                    $plugin = $di->get('AppUser\Plugin\Auth');
                    return $plugin;
                },
                'user-table' => function($sm) {
                                    $dbAdapter = $sm->get('db-config');
                                    $table = new Model\UserTable($dbAdapter);
                                    return $table;
                                },
            ),
        );
    }

    public function initializePlugins($e)
    {
        $locator = $e->getParam('application')->getServiceManager();
        //@TODO clean refactoring when ZF2.0 releaze
        //\Zend\Registry::set('locator',$locator);
        $this->authPlugin = $locator->get('auth-plugin');
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
