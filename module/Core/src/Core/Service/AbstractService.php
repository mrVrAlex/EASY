<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 01.04.12
 * Time: 17:50
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Service;

abstract class AbstractService {

    protected $data = null;

    public function load($id){
        if (is_numeric($id)){
            $this->data = $this->getModelTable()->find($id)->current()->toArray();
        }
        return $this;
    }

    public function getData($key = null){
        if (is_null($key)) {
            return $this->data;
        } elseif (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }

    /**
     * @abstract
     * @return \Core\Db\Table
     */
    abstract public function getModelTable();

}