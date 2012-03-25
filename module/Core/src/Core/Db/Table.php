<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 27.12.11
 * Time: 22:35
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Db;

use Zend\Db\Table\AbstractTable;

abstract class Table extends AbstractTable {

    public function filterField($data){
        //@todo клиент на оптимизацию (Вызывать $this->info(COLS)) + вкл кеширование метаданных
         $info = $this->info();
         return array_intersect_key($data,array_combine($info['cols'],$info['cols']));
    }

    // @todo ДОДЕЛАТЬ МЕТОД
    public function __call($nameMethod,$args){
        $classname = substr(strrchr(get_called_class(), "\\"), 1 );

        $table = substr($classname, 0, -5); // Вырезаем из названия класса Table
        if (stripos($nameMethod,'get') !== false){
            if (($pos = stripos($nameMethod,$table)) !== false){ //если в названии гет - значит делает фетчров по ИД

                $id = (int)$args[0];
                return $this->fetchRow('id = ' . $id)->toArray();
            }
        }

        return null;
    }

    //public function __

}
