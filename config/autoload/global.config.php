<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overridding configuration values from modules, etc.  
 * You would place values in here that are agnostic to the environment and not 
 * sensitive to security. 
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source 
 * control, so do not include passwords or other sensitive information in this 
 * file.
 */

return array(
        'di' => array(
            'instance' => array(
                'alias' => array(
                    'db-config' => 'Zend\Db\Adapter\Adapter',
                ),
                'Zend\Db\Adapter\Adapter' => array(
                    'parameters' => array(
                        'driver' => array(
                            'driver' => 'Mysqli',
                            'host' => 'localhost',
                            'username' => 'root',
                            'password' => '',
                            'dbname' => 'zf2tutorial',
                            'charset' => 'utf8',
                            //'options' => array(
                            //    'profiler' => 'Zend\Db\Profiler\Firebug'
                           //),
                           // 'profiler' => array(
                           //     //'class' => 'Zend\Db\Profiler\Firebug',
                            //    'enabled' => true
                            //)
                            ),
                    )

                ),
                'Zend\Db\Adapter\Driver\Pdo\Pdo' => array(
                    'parameters' => array(
                     //   'config' => array(
                            'host' => 'localhost',
                            'username' => 'root',
                            'password' => '',
                            'dbname' => 'zf2tutorial',
                            'charset' => 'utf8',
                            //'options' => array(
                            //    'profiler' => 'Zend\Db\Profiler\Firebug'
                           //),
                            'profiler' => array(
                                //'class' => 'Zend\Db\Profiler\Firebug',
                                'enabled' => true
                            )
                    //    ),
                    ),
                ),
            ),
        ),
);
