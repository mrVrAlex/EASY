<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 25.02.12
 * Time: 19:34
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Service;

class Randomize {
    static public function getRandName($lenght = 5,$includeTime = 1,$prefix = ''){
        return (string) $prefix.time().'-'.substr(sha1(rand(1,10000)),rand(0,40-$lenght),$lenght);
    }
}