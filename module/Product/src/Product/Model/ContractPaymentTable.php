<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 25.02.12
 * Time: 14:07
 * To change this template use File | Settings | File Templates.
 */
namespace Product\Model;

use Zend\Db,
    Core\Db\Table as DbTable;

class ContractPaymentTable extends DbTable
{
    protected $tableName = 'contract_payments';

    public function insert($data){
        if (!isset($data['dt'])){
            $data['dt'] = new Db\Expr('NOW()');
        }
        return parent::insert($this->filterField($data));
    }

}