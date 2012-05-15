<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 15.05.12
 * Time: 21:51
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Db;

class Collection implements \IteratorAggregate {

    protected $_isLoaded = false;
    /**
     * @var \Core\Db\Table
     */
    protected $_table = null;

    protected $_dataCollection = null;

    public function __construct($table){
        $this->_table = $table;
    }

    public function load(){
        if (!$this->_isLoaded){
            $this->_dataCollection = $this->_table->select();
        }
        return $this;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_dataCollection->toArray());
    }
}