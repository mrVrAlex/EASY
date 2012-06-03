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