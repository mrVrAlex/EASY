<?php
return array(
    'view_manager' => array(
        'template_map' => array(
            'product/product/index' => __DIR__ . '/../views/product/index.phtml',
            'product/credit/index' => __DIR__ . '/../views/credit/index.phtml',
            'product/credit/step1' => __DIR__ . '/../views/credit/step1.phtml',
        ),
        'template_path_stack' => array(
            'product' => __DIR__ . '/../views',
            'credit' => __DIR__ . '/../views',
        ),
    ),
    'router' => array(
        'routes' => array(
            'product' => array(
                'type'    => 'Core\Router\Http\Route',
                'options' => array(
                    'route'    => '/product/:controller/:action/*',
                    'defaults' => array(
                        'controller' => 'Product\Controller\ProductController',
                        'action' => 'index'
                    ),
                ),
            ),
        ),
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'product' => 'Product\Controller\ProductController',
                'credit' => 'Product\Controller\CreditController',
                'service-contract' => 'Product\Service\Contract',
                'service-till' => 'Product\Service\Till',
                'service-appeal' => 'Product\Service\Appeal',
                'service-product' => 'Product\Service\Product'
            ),
            'Product\Model\AppealTable' => array(
                'parameters' => array(
                    'adapter' => 'db-config',
            )),
            'Product\Model\ProductTable' => array(
                'parameters' => array(
                    'adapter' => 'db-config',
            )),
            'Product\Model\ContractTable' => array(
                'parameters' => array(
                    'adapter' => 'db-config',
            )),
            'Product\Model\ContractPaymentTable' => array(
                'parameters' => array(
                    'adapter' => 'db-config',
            )),
            'Product\Model\TillTable' => array(
                'parameters' => array(
                    'adapter' => 'db-config',
            )),
            'Product\Service\Contract' => array(
                'parameters' => array(
                    'till' => 'service-till',
                    'contractTable' => 'Product\Model\ContractTable',
                    'contractPaymentTable' => 'Product\Model\ContractPaymentTable',
                ),
            ),

            'Product\Service\Till' => array(
                'parameters' => array(
                    'tillTable' => 'Product\Model\TillTable',
                ),
            ),

            'Product\Service\Appeal' => array(
                            'parameters' => array(
                                'appealTable' => 'Product\Model\AppealTable',
                            ),
            ),

            'Product\Service\Product' => array(
                            'parameters' => array(
                                'productTable' => 'Product\Model\ProductTable',
                            ),
            ),

            /*'viewRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'product' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ),*/
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'product/product' => __DIR__ . '/../views',
                    ),
                ),
            ),

                        // Setup for router and routes
            'Zend\Mvc\Router\RouteStackInterface' => array(
                'parameters' => array(
                    'routes' => array(

                        'product' => array(
                            'type'    => 'Core\Router\Http\Route',
                            'options' => array(
                                'route'    => '/product/:controller/:action/*',
                                'defaults' => array(
                                    'controller' => 'Product\Controller\ProductController',
                                    'action' => 'index'
                                ),
                            ),/*



                            'type' => 'Zend\Mvc\Router\Http\Part',
                            'options' => array(
                                'route' => array(
                                    'type'    => 'Zend\Mvc\Router\Http\Literal',
                                    'options' => array(
                                        'route'    => '/product',
                                        'defaults' => array(
                                            'controller' => 'Product\Controller\ProductController',
                                            'action' => 'index'
                                        ),
                                    )
                                ),
                                'may_terminate' => true,
                                'route_broker'  => new \Zend\Mvc\Router\RouteBroker(),
                                'child_routes'  => array(
                                    'product_controller' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'    => '/[:controller[/:action]]',
                                            'constraints' => array(
                                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            ),
                                            'defaults' => array(
                                                'controller' => 'Product\Controller\ProductController',
                                                'action' => 'index'
                                            ),
                                        ),
                                        'may_terminate' => true,
                                        'child_routes'  => array(
                                            'rss' => array(
                                                'type'    => 'Core\Router\Http\Route',
                                                'options' => array(
                                                    'route'    => '/:controller/:action/*',
                                                    'defaults' => array(
                                                        'controller' => 'Product\Controller\ProductController',
                                                        'action' => 'index'
                                                    ),
                                                ),/*
                                                'child_routes'  => array(
                                                    'sub' => array(
                                                        'type'    => 'literal',
                                                        'options' => array(
                                                            'route'    => '/sub',
                                                            'defaults' => array(
                                                                'action' => 'ItsSubRss',
                                                            ),
                                                        )
                                                    ),
                                                ),* /
                                            ),
                                        ),
                                    ),
                                    'forum' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => 'forum',
                                            'defaults' => array(
                                                'controller' => 'ItsForum',
                                            ),
                                        ),
                                    ),
                                ),

                            )
                            /*
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/[:controller[/:action]]',
                                'constraints' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                   // 'product' => 'product'
                                ),
                                'defaults' => array(
                                    'controller' => 'Product\Controller\ProductController',
                                    'action'     => 'index',
                                   // 'product' => 'product'
                                ),
                            ),
                            */

                        ),

                    ),
                ),
            ),
        ),
    ),
);
