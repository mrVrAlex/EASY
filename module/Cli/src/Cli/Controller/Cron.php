<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 10.12.11
 * Time: 17:39
 * To change this template use File | Settings | File Templates.
 */
namespace Cli\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Http\Client;


class Cron extends ActionController
{
    public function indexAction()
    {
        return array('content' => 'IT WORKS!');
    }

    public function processingPaymentAction()
    {
        echo 'It works!';
        //return array('content'=>'Works!');
        /**
         * @var $serviceContract \Product\Service\Contract
         */
        $serviceContract = $this->getLocator()->get('service-contract');
        //$data = $serviceContract->load(2)->getData();
        //$ddd = $serviceContract->getActiveContracts();
        //$ddd[0]->
        foreach($serviceContract->getActiveContracts() as $contract){
            $data = $contract->getData();
        }
        print_r($data);
    }

}
