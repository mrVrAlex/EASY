<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 05.03.12
 * Time: 1:10
 * To change this template use File | Settings | File Templates.
 */
namespace PHPExcel;


class Module
{
    public function getAutoloaderConfig()
    {
        define('PHPEXCEL_ROOT', __DIR__. DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . 'vendor' .DIRECTORY_SEPARATOR .'PHPExcel'.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR  );
        require_once(PHPEXCEL_ROOT."PHPExcel.php");
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'prefixes' => array(
                    __NAMESPACE__ => __DIR__. DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . 'vendor' .DIRECTORY_SEPARATOR .'PHPExcel'.DIRECTORY_SEPARATOR.'library' .DIRECTORY_SEPARATOR . __NAMESPACE__,

                ),
            ),
        );
    }

    public function getConfig()
    {
        return array();
        //return include __DIR__ . '/config/module.config.php';
    }
}
