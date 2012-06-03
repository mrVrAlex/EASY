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
    protected $_tableName = 'ClientTable';

    protected $_attributes = array();

    public function load($id){
        if (!$this->_initialized){
            $this->init();
        }
        return $this->_mainModelTable->select(array('id = ?'=>$id))->current();
    }

    protected function getFullTableName(){
        return __NAMESPACE__ . "\\" . $this->_tableName;
    }


}
