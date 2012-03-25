<?php
return array(
    'modules' => array(
        'Core',
        'AppUser',
        'Client',
        'Product',
        'PHPExcel',
        'ZendDeveloperTools'
    ),
    'module_listener_options' => array( 
        'config_cache_enabled' => false,
        'cache_dir'            => 'data/cache',
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
