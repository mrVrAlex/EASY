<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 25.02.12
 * Time: 17:48
 * To change this template use File | Settings | File Templates.
 */
namespace Product\Model;

use Zend\Db,
    Core\Db\Table as DbTable;

class ContractTable extends DbTable
{
    protected $_name = 'contract';

    public function insert($data){
        if (!isset($data['dt'])){
            $data['dt'] = new Db\Expr('NOW()');
        }
        return parent::insert($this->filterField($data));
    }

}