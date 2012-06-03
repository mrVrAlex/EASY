<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 03.06.12
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */
namespace AppUser\Model;

use \Core\Model\AbstractModel,
    Zend\Db\ResultSet\ResultSet;

class User extends AbstractModel
{
    protected $_tableName = 'UserTable';
    protected $_mainTable;
    protected $_initialized = false;
    protected $_adapter;

    protected function init(){
        $this->_tableName = __NAMESPACE__ . "\\" . $this->_tableName;
        $this->mainTable = new $this->_tableName($this->getAdapter(),null,new ResultSet(clone $this));

        $this->_initialized = true;
    }

    public function load($id){
        if (!$this->_initialized){
            $this->init();
        }
        return $this->mainTable->select(array('id = ?'=>$id))->current();
    }

    public function setAdapter($adapter)
    {
        $this->_adapter = $adapter;
    }

    public function getAdapter()
    {
        return $this->_adapter;
    }

}