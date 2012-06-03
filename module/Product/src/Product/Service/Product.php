<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 29.02.12
 * Time: 22:13
 * To change this template use File | Settings | File Templates.
 */
namespace Product\Service;

use Core\Db;

class Product {

    protected $productTable;
    //protected $dataAppeal = null;
    //protected $serviceClient = null;

    public function getAllList(){
        $collection = new Db\Collection($this->getProductTable());
        return $collection->load();
    }

    public function setProductTable($productTable)
    {
        $this->productTable = $productTable;
    }

    public function getProductTable()
    {
        return $this->productTable;
    }


}