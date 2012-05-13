<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 15.01.12
 * Time: 16:38
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Model;

use Zend\Db,
    Core\Db\Table as DbTable;

class BuroCheckTable extends DbTable
{
    protected $tableName = 'buro_check';

    public function insert($data){
        $fieldStat = array(
            'check_date' => new Db\Expr('NOW()'),
        );
        $data += $fieldStat;
        return parent::insert($this->filterField($data));
    }
}