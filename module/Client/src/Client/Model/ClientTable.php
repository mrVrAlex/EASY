<?php

namespace Client\Model;

use Core\Db\Table as DbTable,
    Zend\Db\TableGateway\AbstractTableGateway;

class ClientTable extends DbTable
{
    protected $tableName = 'client_entity';
}