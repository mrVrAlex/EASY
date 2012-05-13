<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'adminpanel' => 'AdminPanel\Controller\AdminPanelController',
                'admin-panel' => 'AdminPanel\Controller\AdminPanelController',
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'AdminPanel' => __DIR__ . '/../view',
                    ),
                ),
            ),
                        // Defining where the layout/layout view should be located
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                        'layout/admin' => __DIR__ . '/../view/layout/admin.phtml',
                    ),
                ),
            ),

                        // Setup for router and routes
            'Zend\Mvc\Router\RouteStackInterface' => array(
                'parameters' => array(
                    'routes' => array(
                        'adminhome' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/adminpanel',
                                'defaults' => array(
                                    'controller' => 'AdminPanel\Controller\AdminPanelController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'admin' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/adminpanel[/:controller[/:action]]',
                                'constraints' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'AdminPanel\Controller\AdminPanelController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),

                    ),
                ),
            ),
        ),
    ),
);
