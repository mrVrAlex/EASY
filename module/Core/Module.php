<?php

namespace Core;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{
    protected $view;
    protected $viewListener;

    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'initializeView'), 100);
        $events->attach('bootstrap', 'bootstrap', array($this, 'initializeTranslator'), 101);
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
        $locator      = $app->getLocator();
        $config       = $e->getParam('config');
        $view         = $this->getView($app);
        \Zend\Dojo\Dojo::enableView($view);
        $viewListener = $this->getViewListener($view, $config);
        $app->events()->attachAggregate($viewListener);
        $events       = StaticEventManager::getInstance();
        $viewListener->registerStaticListeners($events, $locator);
    }

    protected function getViewListener($view, $config)
    {
        if ($this->viewListener instanceof View\Listener) {
            return $this->viewListener;
        }

        $viewListener       = new View\Listener($view, $config->layout);
        $viewListener->setDisplayExceptionsFlag($config->display_exceptions);

        $this->viewListener = $viewListener;
        return $viewListener;
    }

    protected function getView($app)
    {
        if ($this->view) {
            return $this->view;
        }

        $di     = $app->getLocator();
        $view   = $di->get('view');
        $url    = $view->plugin('url');
        $url->setRouter($app->getRouter());

        $view->plugin('headTitle')->setSeparator(' - ')
                                  ->setAutoEscape(false)
                                  ->append('Посто-деньги');

        $basePath = $app->getRequest()->detectBaseUrl();

        //$view->plugin('headLink')->appendStylesheet($basePath . 'css/bootstrap.min.css');
        $view->plugin('headLink')->appendStylesheet($basePath . 'css/style.css');
        $html5js = '<script src="' . $basePath . 'js/html5.js"></script>';
        $view->plugin('placeHolder')->__invoke('html5js')->set($html5js);
        $favicon = '<link rel="shortcut icon" href="' . $basePath . 'images/favicon.ico">';
        $view->plugin('placeHolder')->__invoke('favicon')->set($favicon);
        $view->plugin('doctype')->__invoke('XHTML1_TRANSITIONAL');

        $this->view = $view;
        return $view;
    }
}
