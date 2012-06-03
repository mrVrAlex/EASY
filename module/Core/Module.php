<?php

namespace Core;

use Zend\ModuleManager\ModuleManager,
    Zend\EventManager\StaticEventManager;

class Module
{
    static protected $_app = null;

    public function onBootstrap($e)
    {
        $application        = $e->getParam('application');
        $events       = $application->events();
        $sharedEvents = $events->getSharedManager();
        $this->initializeView($e);
        $this->initializeTranslator($e);
        self::$_app = $application;
        //$sharedEvents->attach('application', 'bootstrap', array($this, 'initializeView'),100);
        //$sharedEvents->attach('application', 'dispatch', array($this, 'initializeTranslator'), -1);
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

    /**
     * @static
     * @param $name
     * @return Model\AbstractModel
     * @throws \ErrorException
     */
    public static function getModel($name){
        $sm = self::$_app->getServiceManager();
        $di = $sm->get('Di');
        $arr = explode('/',$name);

        $model = $di->get($arr[0]."\\Model\\".$arr[1]);
        if ($model instanceof Model\AbstractModel){
            return $model;
        }
        throw new \ErrorException('Not found model '.$name);
    }


    
    public function initializeView($e)
    {
        $app          = $e->getParam('application');
        $basePath     = '/';//$app->getRequest()->getBasePath();
        $locator      = $app->getServiceManager();
        /**
         * @var $renderer \Zend\View\Renderer\PhpRenderer
         */
        $renderer     = $locator->get('viewrenderer');
        $broker = $renderer->getBroker();//etBroker($locator->get('Zend\View\HelperBroker'));
        $broker->register('userInfo',new \AppUser\View\Helper\UserInfo());
        //\Zend\View\HelperLoader::addStaticMap(array(
        //                         'userInfo' => 'AppUser\View\Helper\UserInfo'
        //                     ));
        $renderer->plugin('basePath')->setBasePath($basePath);
        //$renderer->plugin('headLink')->appendStylesheet($basePath . 'css/bootstrap.min.css');
        $renderer->plugin('headLink')->appendStylesheet($basePath . 'css/style.css');
        $html5js = '<script src="' . $basePath . 'js/html5.js"></script>';
        $renderer->plugin('placeHolder')->__invoke('html5js')->set($html5js);
        $favicon = '<link rel="shortcut icon" href="' . $basePath . 'images/favicon.ico">';
        $renderer->plugin('placeHolder')->__invoke('favicon')->set($favicon);
        $renderer->plugin('doctype')->__invoke('XHTML1_TRANSITIONAL');
    }
}
