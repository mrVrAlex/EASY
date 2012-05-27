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
                    'adapter' => 'db-config',
            )),

            'AppUser\View\Helper\UserInfo' => array(
                'parameters' => array(
                    'view' => 'viewrenderer'
                ),
            ),
            'Zend\View\Helper\Loader' => array(
                 'parameters' => array(
                    'map' => array(
                         'userInfo' => 'AppUser\View\Helper\UserInfo'
                     ),
                 ),
            ),
            'Zend\View\HelperBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\View\HelperLoader',
                ),
            ),

            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'user' => __DIR__ . '/../views',
                    ),
                ),
            ),
            'AppUser\Plugin\Auth'=> array(
                'parameters' => array(
                   // 'authenticationService' => '\Zend\Authentication\AuthenticationService'
                )
            ),/*
            'Zend\Mvc\Controller\PluginLoader' => array(
                'parameters' => array(
                    'plugins' => array(
                        'auth' => 'AppUser\Plugin\Auth',
                        'locator' => '\Zend\Di\Di'
                    ),
                ),
            ),*/



        ),
    ),
    'routes' => array(

    )


);
