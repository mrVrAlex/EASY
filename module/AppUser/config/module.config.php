<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'user' => 'AppUser\Controller\UserController',
		        'auth-service' => 'Zend\Authentication\AuthenticationService',
               
            ),
            'AppUser\Controller\UserController' => array(
                'parameters' => array(
                    'userTable' => 'AppUser\Model\UserTable',
                ),
            ),
            'AppUser\Model\UserTable' => array(
                'parameters' => array(
                    'config' => 'db-config',
            )),

            'AppUser\View\Helper\UserInfo' => array(
                'parameters' => array(
                    'view' => 'Zend\View\PhpRenderer'
                ),
            ),

            'Zend\View\HelperBroker' =>array(
                'parameters' => array(
                    'options'  => array(
                        'class_loader' => array(
                            'class' => 'Zend\View\HelperLoader',
                            'options' => array(
                                'userInfo'=>'AppUser\View\Helper\UserInfo',
                                'currentInfo'=>'Client\View\Helper\CurrentInfo'
                            ),
                        ),
                        'register_plugins_on_load' => true,
                        //'plugins' => array('userInfo'=>'AppUser\View\Helper\UserInfo'),
                    ),
                    //'locator' => '\Zend\Di\Di'
                ),
            ),

            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'user' => __DIR__ . '/../views',
                        ),
                        'broker' => 'Zend\View\HelperBroker'
                    ),
                ),
            ),
            'AppUser\Plugin\Auth'=> array(
                'parameters' => array(
                   // 'authenticationService' => '\Zend\Authentication\AuthenticationService'
                )
            ),
            'Zend\Mvc\Controller\PluginLoader' => array(
                'parameters' => array(
                    'plugins' => array(
                        'auth' => 'AppUser\Plugin\Auth',
                        'locator' => '\Zend\Di\Di'
                    ),
                ),
            ),



        ),
    ),
    'routes' => array(

    )
);
