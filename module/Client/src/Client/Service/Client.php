<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 29.02.12
 * Time: 22:22
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Service;

class Client {

    const DATA_INFO_MAIN = 'main';
    const DATA_INFO_JOBS = 'jobs';
    const DATA_INFO_ALL = 'all';

    protected $clientHistoryTable;

    /**
     * @var \Client\Model\ClientTable
     */
    protected $clientTable;

    /**
      * @var array|null
      */
    protected $dataClient = null;

    public function create(array $data){
        $data['data'] = json_encode( array(self::DATA_INFO_MAIN => array(),self::DATA_INFO_JOBS => array(),self::DATA_INFO_ALL => array()) );
        return $this->getClientTable()->insert($data);
    }

    public function updateData(array $data,$additionalDataUpdateFlag = false,$section = null){
        if (is_null($this->dataClient) || !isset($this->dataClient['id']) ){
            return;
        }
        $dataUpdate = array();
        if ($additionalDataUpdateFlag === false){
            $dataUpdate = $data;
        } else {
            switch ($section){
                case self::DATA_INFO_MAIN:
                case self::DATA_INFO_JOBS:
                case self::DATA_INFO_ALL:
                    $this->dataClient['data'][$section] = array_merge($this->dataClient['data'][$section],$data);
                    $dataUpdate['data'] = json_encode($this->dataClient['data']);
                break;
                default: $dataUpdate['data'] = json_encode($data); break;
            }

        }

        return $this->getClientTable()->update($dataUpdate,array('id'=>$this->dataClient['id']));
    }

    public function load($id){
        if (is_numeric($id)){
            $this->dataClient = $this->getClientTable()->find($id)->current()->toArray();
            $this->dataClient['data'] = json_decode($this->dataClient['data'],true);
        }
        return $this;
    }

    public function getData($key = null){
        if (is_null($key)) {
            return $this->dataClient;
        } elseif (isset($this->dataClient[$key])) {
            return $this->dataClient[$key];
        }

        return null;

    }

    public function findUniq(array $data = array()){

        if (!isset($data['firstname']) || !isset($data['lastname']) || !isset($data['patronymic']) || !isset($data['birthdate'])){
            return null;
        }
        $row = $this->getClientTable()
                    ->fetchRow(array("LOWER(firstname) LIKE ?" => ($data['firstname']),
                                     "LOWER(lastname) LIKE ?" => ($data['lastname']),
                                     "LOWER(patronymic) LIKE ?" => ($data['patronymic']),
                                     "birthdate = ?" => $data['birthdate']
                                    ));

        return isset($row['id'])?(int)$row['id']:null;
    }

    public function setClientHistoryTable($clientHistoryTable)
    {
        $this->clientHistoryTable = $clientHistoryTable;
    }

    public function getClientHistoryTable()
    {
        return $this->clientHistoryTable;
    }

    public function setClientTable($clientTable)
    {
        $this->clientTable = $clientTable;
    }

    public function getClientTable()
    {
        return $this->clientTable;
    }
}