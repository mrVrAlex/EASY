<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 15.01.12
 * Time: 12:32
 * To change this template use File | Settings | File Templates.
 */
 
namespace Product\Model;

use Zend\Db,
    Core\Db\Table as DbTable;

class ProductTable extends DbTable
{
    protected $_name = 'products';
    
}