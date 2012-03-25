<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'client' => 'Client\Controller\ClientController',
                'service-client' => 'Client\Service\Client'
            ),
            'Client\Controller\ClientController' => array(
                'parameters' => array(
                    'serviceClient' => 'service-client',
                   // 'clientHistory' => 'Client\Model\ClientHistoryTable',
                ),
            ),
            'Client\Model\ClientTable' => array(
                'parameters' => array(
                    'config' => 'db-config',
            )),
            'Client\Model\ClientHistoryTable' => array(
                'parameters' => array(
                    'config' => 'db-config',
            )),
            'Client\Model\BuroCheckTable' => array(
                'parameters' => array(
                    'config' => 'db-config',
            )),
            'Client\Service\Client' => array(
                'parameters' => array(
                    'clientHistoryTable' => 'Client\Model\ClientHistoryTable',
                    'clientTable' => 'Client\Model\ClientTable'
            )),

            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'client' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'routes' => array(

    )
);
