<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 29.02.12
 * Time: 22:13
 * To change this template use File | Settings | File Templates.
 */
namespace Product\Service;

class Appeal {

    protected $appealTable;


    public function load(){

    }

    public function setAppealTable($appealTable)
    {
        $this->appealTable = $appealTable;
    }

    public function getAppealTable()
    {
        return $this->appealTable;
    }
}