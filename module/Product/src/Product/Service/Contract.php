<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 15.01.12
 * Time: 22:47
 * To change this template use File | Settings | File Templates.
 */
 namespace Product\Service;

 use Zend\Loader\LocatorAware;

 class Contract
 {
     const TYPE_PAY_LOAN = 'loan';
     const TYPE_PAY_PLAN = 'plan';
     const TYPE_PAY_PERCENT = 'percent';
     const TYPE_PAY_DEPT = 'debt';
     const TYPE_PAY_INTER = 'inter';
     const TYPE_PAY_FINE = 'fine';

     protected $locator;
     /**
      * @var $till \Product\Service\Till
      */
     protected $till;
     /**
      * @var $contractTable \Product\Model\ContractTable
      */
     protected $contractTable;
     /**
      * @var $contractTable \Product\Model\ContractPaymentTable
      */
     protected $contractPaymentTable;
     /**
      * @var array|null
      */
     protected $dataContract = null;

     /**
      * Создание договора из текущей заявки
      * @param array $dataAppeal
      * @return int
      */
     public function create(array $dataAppeal){
         unset($dataAppeal['id']);
         //Создаем запись в таблице контракта - с данными по заявки (юзер, клиент, отделение, продукт)
         $dataAppeal['fname'] = \Core\Service\Randomize::getRandName(4,1,'contract-');
         $contract_id = $this->getContractTable()->insert($dataAppeal);
         //Загружаем данные по контракту
         $this->load($contract_id);
         //Делаем движение по этому контракту (создаем строку в табице платежей по контракту contractPayment )
         $this->payment(self::TYPE_PAY_LOAN,$dataAppeal['loan_amount'],$dataAppeal['user_id'],$dataAppeal['branch_id']);

         return $contract_id;
     }

     public function payment($type,$money,$user_id = 0 ,$brach_id = 0){
         if ($this->dataContract === null) return false;

         switch ($type){
             case self::TYPE_PAY_LOAN: {
                 //Делаем движение по кассе - выдача
                 $till_id = $this->getTill()->outMoney($money);
                 if ($till_id !== null){
                     $data = array('contract_id' => $this->dataContract['id'],
                                   'user_id'     => $user_id,
                                   'branch_id'   => $brach_id,
                                   'summa'       => $money,
                                   'type'        => self::TYPE_PAY_LOAN,
                                   'till_id'     => $till_id
                             );
                     $this->getContractPaymentTable()->insert($data);
                     $dataTill = $this->getTill()->load($till_id)->getData();

                 }
             } break;


         }



     }

     public function load($id){
             $this->dataContract = $this->getContractTable()->fetchRow('id = '.(int)$id)->toArray();
         return $this;
     }

     public function getPaymentData($byFilter = null){
         if ($this->dataContract === null) return false;

         $data = array('contract_id = ?'=>$this->dataContract['id']);
         if (!is_null($byFilter) && is_array($byFilter)){
             $data = $data + $byFilter;
         }

         return $this->getContractPaymentTable()->fetchAll($data)->toArray();
     }

     /**
      * @return Contract[]
      */
     public function getActiveContracts(){
         $contracts = array();
         $data = $this->getContractTable()->getContractByActive(true);
         foreach ($data as $row){
             $contract = clone $this;
             $contract->load($row['id']);
             $contracts[] = $contract;
         }
         return $contracts;
     }

     public function printContract(){

     }

     public function printRKO(){

         $dataPayment = $this->getPaymentData(array('type = ?'=>self::TYPE_PAY_LOAN));
         $dataTill = $this->getTill()->load($dataPayment[0]['till_id'])->getData();

         return array('payment'=>$dataPayment[0],'till'=>$dataTill);
     }

     public function setTill($till)
     {
         $this->till = $till;
     }

     public function getTill()
     {
         return $this->till;
     }

     public function setContractTable($contractTable)
     {
         $this->contractTable = $contractTable;
     }

     public function getContractTable()
     {
         return $this->contractTable;
     }

     public function setLocator($locator)
     {
         $this->locator = $locator;
     }

     public function getLocator()
     {
         return $this->locator;
     }

     public function setContractPaymentTable($contractPaymentTable)
     {
         $this->contractPaymentTable = $contractPaymentTable;
     }

     public function getContractPaymentTable()
     {
         return $this->contractPaymentTable;
     }

     /**
      * @return array|null
      */
     public function getData()
     {
         return $this->dataContract;
     }


 }
