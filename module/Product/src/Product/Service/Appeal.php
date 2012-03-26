<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 29.02.12
 * Time: 22:13
 * To change this template use File | Settings | File Templates.
 */
namespace Product\Service;

use Client\Service\Client;

class Appeal {

    protected $appealTable;
    protected $dataAppeal = null;
    protected $serviceClient = null;

    public function load($id){
        if (is_numeric($id)){
            $this->dataAppeal = $this->getAppealTable()->find($id)->current()->toArray();
            //$this->dataAppeal['data'] = json_decode($this->dataClient['data'],true);
        }
        return $this;
    }

    public function getData($key = null){
        if (is_null($key)) {
            return $this->dataAppeal;
        } elseif (isset($this->dataAppeal[$key])) {
            return $this->dataAppeal[$key];
        }

        return null;
    }

    public function setAppealTable($appealTable)
    {
        $this->appealTable = $appealTable;
    }

    public function getAppealTable()
    {
        return $this->appealTable;
    }

    public function setServiceClient(Client $serviceClient){
        $this->serviceClient = $serviceClient;
        return $this;
    }

    public function getClientData($key = null){

        if ($this->serviceClient instanceof Client){
            return $this->serviceClient->load($this->dataAppeal['client_id'])->getData($key);
        }
        return null;
    }


}