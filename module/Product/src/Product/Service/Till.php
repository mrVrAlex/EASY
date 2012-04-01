<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 15.01.12
 * Time: 23:06
 * To change this template use File | Settings | File Templates.
 */
 
 namespace Product\Service;

 use Core\Service;
 /**
  *
  */
class Till extends Service\AbstractService
{
     /**
      * @var \Product\Model\TillTable
      */
     protected $tillTable;
     /**
      * Выдача денег из кассы
      *
      * @return int|null
      * @param float|int $money
      * @param int $user_id
      * @param int $branch_id
      */
     public function outMoney($money,$user_id = 0,$branch_id = 0){
         $this->getTillTable()->getAdapter()->beginTransaction();
         try {
             $currentBalance = $this->getTillTable()->getLastBalance();
             $endBalance = $currentBalance - $money;
             $fname = $this->createRKO();
             $data = array('outcome'    => $money,
                           'balance'    => $endBalance,
                           'user_id'    => $user_id,
                           'branch_id'  => $branch_id,
                           'fname'      => $fname
                     );
             $id = $this->getTillTable()->insert($data);
             $this->getTillTable()->getAdapter()->commit();
         } catch (\Exception $e){
             $this->getTillTable()->getAdapter()->rollBack();
         }

         return (isset($id) && ($id > 0))? $id : null;
     }

     public function inMoney(){

     }

     protected function createRKO(){
        //@todo заглушка
         $fname = \Core\Service\Randomize::getRandName();
         return (string)$fname;
     }

     public function setTillTable($tillTable)
     {
         $this->tillTable = $tillTable;
     }

     public function getTillTable()
     {
         return $this->tillTable;
     }

    /**
     * @return \Core\Db\Table
     */
    public function getModelTable()
    {
        return $this->getTillTable();
    }
}