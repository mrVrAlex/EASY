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
                    'adapter' => 'db-config',
            )),
            'Client\Model\ClientHistoryTable' => array(
                'parameters' => array(
                    'adapter' => 'db-config',
            )),
            'Client\Model\BuroCheckTable' => array(
                'parameters' => array(
                    'adapter' => 'db-config',
            )),
            'Client\Service\Client' => array(
                'parameters' => array(
                    'clientHistoryTable' => 'Client\Model\ClientHistoryTable',
                    'clientTable' => 'Client\Model\ClientTable'
            )),

            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'client' => __DIR__ . '/../views',
                    ),
                ),
            ),
        ),
    ),
    'routes' => array(

    )
);
