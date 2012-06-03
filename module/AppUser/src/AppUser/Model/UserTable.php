<?php

namespace AppUser\Model;

use Core\Db\Table as DbTable,
    Zend\Db\Sql;

class UserTable extends DbTable
{
    protected $tableName = 'users';
}