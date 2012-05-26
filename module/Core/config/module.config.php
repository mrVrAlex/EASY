<?php
return array(
   /* 'di'                    => array(
        'instance' => array(
            'alias' => array(
                'index' => 'Core\Controller\IndexController',
               // 'error' => 'Core\Controller\ErrorController',
                'viewRenderer'  => 'Zend\View\Renderer\PhpRenderer',
            ),
            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker'       => 'Zend\Mvc\Controller\PluginBroker',
                ),
            ),
            'Zend\Mvc\Controller\PluginBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\Mvc\Controller\PluginLoader',
                ),
            ),
            // Setup for router and routes
            'Zend\Mvc\Router\RouteStackInterface' => array(
                'parameters' => array(

                ),
            ),
            // Setup for the view layer.
            // Using the PhpRenderer, which just handles html produced by php
            // scripts
            'Zend\View\Renderer\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
                ),
            ),
            // Defining how the view scripts should be resolved by stacking up
            // a Zend\View\Resolver\TemplateMapResolver and a
            // Zend\View\Resolver\TemplatePathStack
            'Zend\View\Resolver\AggregateResolver' => array(
                'injections' => array(
                    'Zend\View\Resolver\TemplateMapResolver',
                    'Zend\View\Resolver\TemplatePathStack',
                ),
            ),
            // Defining where the layout/layout view should be located
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                        'layout/layout' => __DIR__ . '/../views/layouts/layout.phtml',
                    ),
                ),
            ),
            // Defining where to look for views. This works with multiple paths,
            // very similar to include_path
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'core' => __DIR__ . '/../views',
                    ),
                ),
            ),
            // View for the layout
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'layoutTemplate' => 'layout/layout',
                ),
            ),
            // Injecting the router into the url helper
            'Zend\View\Helper\Url' => array(
                'parameters' => array(
                    'router' => 'Zend\Mvc\Router\RouteStackInterface',
                ),
            ),
            // Configuration for the doctype helper
            'Zend\View\Helper\Doctype' => array(
                'parameters' => array(
                    'doctype' => 'HTML5',
                ),
            ),
            // View script rendered in case of 404 exception
            'Zend\Mvc\View\RouteNotFoundStrategy' => array(
                'parameters' => array(
                    'displayNotFoundReason' => true,
                    'displayExceptions'     => true,
                    'notFoundTemplate'      => 'error/404',
                ),
            ),
            // View script rendered in case of other exceptions
            'Zend\Mvc\View\ExceptionStrategy' => array(
                'parameters' => array(
                    'displayExceptions' => true,
                    'exceptionTemplate' => 'error/index',
                ),
            ),
        ),
    ), */

    'router' => array(
        'routes' => array(
            'default' => array(

                'type' => 'Core\Router\Http\Route',
                'options' => array(
                    'route' => '/:controller/:action/*',
                    'defaults' => array(
                        'controller' => 'error',
                        'action' => 'index'
                    ),

                ),
            ),
            /*
            'default' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/[:controller[/:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Core\Controller\IndexController',
                        'action'     => 'index',
                    ),
                ),
            ),*/
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controller' => array(
        'classes' => array(
            'index' => 'Core\Controller\IndexController'
        ),
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        //'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../views/layouts/layout.phtml',
            'core/index/index' => __DIR__ . '/../views/index/index.phtml',
            'error/404' => __DIR__ . '/../views/error/404.phtml',
            'error/index' => __DIR__ . '/../views/error/index.phtml',
        ),
        'template_path_stack' => array(
            'index' => __DIR__ . '/../views',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
            'ViewFeedStrategy',
        ),
    ),
);
