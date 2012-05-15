<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'product' => 'Product\Controller\ProductController',
                'service-contract' => 'Product\Service\Contract',
                'service-till' => 'Product\Service\Till',
                'service-appeal' => 'Product\Service\Appeal',
                'service-product' => 'Product\Service\Product'
            ),
            //'Product\Controller\AlbumController' => array(
            //    'parameters' => array(
                    //'albumTable' => 'Product\Model\AlbumTable',
            //    ),
           // ),
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
                        'product' => __DIR__ . '/../views',
                    ),
                ),
            ),
        ),
    ),
);
