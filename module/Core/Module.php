<?php

namespace Core;

use Zend\ModuleManager\ModuleManager,
    Zend\EventManager\StaticEventManager;

class Module
{

    public function onBootstrap($e)
    {
        $application        = $e->getParam('application');
        $events       = $application->events();
        $sharedEvents = $events->getSharedManager();
        $this->initializeView($e);
        //$sharedEvents->attach('application', 'bootstrap', array($this, 'initializeView'),100);
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', array($this, 'initializeTranslator'), 101);
        //$sharedEvents->attach('bootstrap', 'bootstrap', array($this, 'initializeTranslator'), 101);
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

    public function initializeTranslator($e){
        $translator = new \Zend\Translator\Translator(\Zend\Translator\Translator::AN_ARRAY,__DIR__ . '/../../data/locale/ru/Zend_Validate.php');
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


    
    public function initializeView($e)
    {
        $app          = $e->getParam('application');
        $basePath     = '/';//$app->getRequest()->getBasePath();
        $locator      = $app->getServiceManager();
        $renderer     = $locator->get('viewrenderer');
        $renderer->plugin('basePath')->setBasePath($basePath);
                //$view->plugin('headLink')->appendStylesheet($basePath . 'css/bootstrap.min.css');
        $renderer->plugin('headLink')->appendStylesheet($basePath . 'css/style.css');
        $html5js = '<script src="' . $basePath . 'js/html5.js"></script>';
        $renderer->plugin('placeHolder')->__invoke('html5js')->set($html5js);
        $favicon = '<link rel="shortcut icon" href="' . $basePath . 'images/favicon.ico">';
        $renderer->plugin('placeHolder')->__invoke('favicon')->set($favicon);
        $renderer->plugin('doctype')->__invoke('XHTML1_TRANSITIONAL');
    }
}
