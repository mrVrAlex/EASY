<?php

namespace AdminPanel;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
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

    public function init(Manager $moduleManager)
    {
        $events       = $moduleManager->events();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach('bootstrap', 'bootstrap', array($this, 'initializeView'), 101);
    }

    public function initializeView($e)
    {
        //$app          = $e->getParam('application');
        //$basePath     = $app->getRequest()->getModul();
        //$locator      = $app->getLocator();
        //$renderer     = $locator->get('Zend\View\Renderer\PhpRenderer');
        //$renderer->layout('layout/admin');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}