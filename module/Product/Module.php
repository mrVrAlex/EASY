<?php

namespace Product;

use Zend\ModuleManager\ModuleManager,
    Zend\EventManager\StaticEventManager,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module
{
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

    public function init(ModuleManager $moduleManager)
    {
        $moduleManager->events()->attach('loadModules.post', array($this, 'modulesLoaded'));
    }

    public function modulesLoaded($e)
    {
        $config = $e->getConfigListener()->getMergedConfig();
        //static::$options = $config['zfcuser'];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfiguration()
        {
           /* return array(
                'factories' => array(
                    'Product\Model\ProductTable' => function($sm) {
                        $config = $sm->get('db-config');
                        //$config = $config['db'];
                        $dbAdapter = new \Product\Model\ProductTable($config);
                        return $dbAdapter;
                    },
                    //'Product\Service\Product' => function($sm){
                    //      $service = new \Product\Service\Product();
                    //      $service->setProductTable($sm->get('Product\Model\ProductTable'));
                    //      return $service;
                    //},
                ),
            );*/
        }
}
