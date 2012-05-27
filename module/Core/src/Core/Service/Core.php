<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 27.05.12
 * Time: 20:37
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Service;

class Core {

    static public function toCamelCase($name){
        return implode('',array_map('ucfirst', explode('_',$name)));
    }

}