<?php
return array(
    'modules' => array(
        'Core',
        //'AppUser',
        //'Client',
        'Product',
        //'PHPExcel',
       // 'ZendDeveloperTools'
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.config.php',
        ),
        'config_cache_enabled' => false,
        'cache_dir' => 'data/cache',
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
    'service_manager' => array(
        'use_defaults' => true,
        'factories' => array(
        ),
    ),
);
