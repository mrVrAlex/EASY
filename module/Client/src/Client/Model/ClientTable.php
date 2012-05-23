<?php

namespace Client\Model;

use Core\Db\Table as DbTable,
    Zend\Db\TableGateway\AbstractTableGateway;

class ClientTable extends AbstractTableGateway
{
    protected $tableName = 'clients';

    public function setup(){
        $this->lazyInitialize = true;
    }
    /*public function insert($data){
        $fieldStat = array(
            'add_date' => new Sql\Expression('NOW()'),
        );
        $data += $fieldStat;
        return parent::insert($this->filterField($data));
    }*/


}