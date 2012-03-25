<?php
/*/ Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_patz
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(__DIR__ . '/../../../vendor'),
    realpath(__DIR__ . '/../../../vendor/ZendFramework/library'),
    get_include_path(),
)));
/*/
//chdir(dirname(__DIR__));
chdir(dirname(__DIR__.'/../../../../'));
//............
require_once (getenv('ZF2_PATH') ?: 'vendor/ZendFramework/library') . '/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array()));

//require_once 'Zend/Loader/AutoloaderFactory.php';
//Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array()));

$appConfig = include __DIR__ . '/../../../config/application.config.php';

$modules = $appConfig['modules'];
$modules[] = 'Cli';

$moduleLoader = new Zend\Loader\ModuleAutoloader($appConfig['module_paths']);
$moduleLoader->register();


$listenerOptions = new Zend\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
//$moduleManager->setDefaultListenerOptions($listenerOptions);
$defaultListeners->getConfigListener()->addConfigGlobPath( __DIR__ .'/../../../config/autoload/*.config.php');
//$moduleManager->getConfigListener()->addConfigGlobPath(dirname(__DIR__) . '/config/autoload/*.config.php');
$moduleManager = new Zend\Module\Manager($modules);
$moduleManager->events()->attachAggregate($defaultListeners);
$moduleManager->loadModules();



// Get the merged config object
$config = $defaultListeners->getConfigListener()->getMergedConfig();//$moduleManager->getMergedConfig();

// Create application, bootstrap, and run

$bootstrap = new $config->cli_bootstrap_class($config);
$application = new Cli\Application;
$bootstrap->bootstrap($application);
$application->run();
//$application->run()->send();