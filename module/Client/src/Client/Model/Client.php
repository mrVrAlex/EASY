<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 20.05.12
 * Time: 18:46
 * To change this template use File | Settings | File Templates.
 */

namespace Client\Model;

use Core\Model\AbstractModel,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\Sql;
class Client extends AbstractModel
{
    /**
     * @var ClientTable
     */
    protected $_table;

    protected $_attributes = array();

    public function load($id){

        //$this->getTable()->getTable()
        //$sql = new Sql\Sql($this->getTable()->getAdapter(), $this->getTable()->getTable(),$this->getTable()->getAdapter()->getPlatform());
        //var_export($sql);
        //print_r($sql->getTable());
        //$sql->select($this->getTable()->getTable());// =
        $sql = $this->getTable()->getSql()->select();
        //$sql->join('eav_attribute','eav_attribute.entity_type_id = client_entity.entity_type_id',$sql::SQL_STAR,$sql::JOIN_LEFT);
        //$sql->join('client_entity_value','eav_attribute.attribute_id = client_entity_value.attribute_id',$sql::SQL_STAR,$sql::JOIN_LEFT);
        $this->getTable()->initialize();
        return $this->getTable()->select();
    }




    public function setTable($table)
    {
        $this->_table = $table;
    }
    /**
     * @return ClientTable
     */
    public function getTable()
    {
        return $this->_table;
    }

}
