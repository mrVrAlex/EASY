<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 25.02.12
 * Time: 15:20
 * To change this template use File | Settings | File Templates.
 */
namespace Product\Model;

use Zend\Db,
    Core\Db\Table as DbTable;

class TillTable extends DbTable
{
    protected $_name = 'till';

    public function getLastBalance($branch_id = 0){
        $select = $this->select()
                       ->from($this)
                       ->columns(new Db\Expr('MAX(id)'));
        return (int) $this->getAdapter()->fetchOne($select);
    }

    public function insert($data){
        if (!isset($data['dt'])){
            $data['dt'] = new Db\Expr('NOW()');
        }
        return parent::insert($this->filterField($data));
    }

}