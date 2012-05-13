<?php

namespace Client\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Client\Model\ClientTable,
    Client\Form\AddForm,
    Client\Service;

class ClientController extends ActionController
{
    /**
     * @var \Client\Service\Client
     */
    protected $serviceClient;
    //protected $clientHistory;

    public function addAction()
    {
      //@todo Прверка продукта или нулл
        $product_id = $this->getRequest()->getMetadata('product', 1);

        $form = new AddForm();
        $form->product_id->setValue($product_id);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $values = $form->getValues();
                $userProfile = $this->getLocator()->get('auth-service')->getIdentity();
                $values['user_id'] = $userProfile['id'];
                $values['branch_id'] = $userProfile['branch_id'];
                try {
                    $client_id = $this->getServiceClient()->findUniq($values);
                    if ($client_id === null){
                        //$values['data'] = '{}';
                        $client_id = $this->getServiceClient()->create($values);
                        $dataAdditional = array('passport'=>$values['passport'],'address_reg'=>$values['address_reg'],'address_real'=>$values['address_real']);
                        $this->getServiceClient()->load($client_id)->updateData($dataAdditional,true,Service\Client::DATA_INFO_MAIN);
                        $client_flag = 'new';
                        //$this->client->getAdapter()->beginTransaction();
                    } else {
                        $client_flag = 'old';
                    // $this->client->copyRow(id,$clientHistory);
                    // $this->client->update
                    }

                    $appealTable = $this->getLocator()->get('Product\Model\AppealTable');
                       $values['client_id'] = $client_id;
                       $appeal_id = $appealTable->insert($values);

                    //$this->client->getAdapter()->commit();
                } catch (\Exception $e){
                    //$this->client->getAdapter()->rollBack();
                    throw new \Exception($e->getMessage());
                }
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'client',
                    'action'     => 'step3',
                    'appeal' => $appeal_id,
                    'cflag' => $client_flag
                ));
            }
        }
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function step3Action(){
        $request = $this->getRequest();
        $appeal_id = $request->getMetadata('appeal', null);
        $cflag = $request->getMetadata('cflag', null);

        // @todo refactoring !!!!

        $appealTable = $this->getLocator()->get('Product\Model\AppealTable');
        $rowAppeal = $appealTable->getAppealById($appeal_id);
        $seviceClient = $this->getServiceClient();

        $section = $seviceClient::DATA_INFO_JOBS;
        $dataAdditionalClient = $seviceClient->load($rowAppeal['client_id'])->getData('data');
        $dataClient = $dataAdditionalClient[$section];
        $newClientFlag = ( count($dataClient) == 0 ) ? true : false;

        $productTable = $this->getLocator()->get('Product\Model\ProductTable');
        $rowProduct = $productTable->getProductById($rowAppeal['product_id']);
        $clientFormSetting = json_decode($rowProduct['client_data'],true);

        $options = array(
            'form_constructor'=> $clientFormSetting['forms'][$section]
        );
        $options['form_constructor']['confirm'] = !$newClientFlag;

        $form = new \Client\Form\CustomizedForm($options);
        //Если клиент новый то
        if (!$newClientFlag){
            $form->populate($dataClient);
        }

        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $values = $form->getValues();
                $seviceClient->updateData($values,true,$seviceClient::DATA_INFO_JOBS);
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'client',
                    'action'     => 'stepCheck',
                    'appeal' => $appeal_id
                ));
            }

        }
        return array(
            'form' =>$form,
            'appeal_id' => $appeal_id
        );
    }


    public function stepCheckAction(){

        $appeal_id = $this->getRequest()->getMetadata('appeal', null);

        $appealTable = $this->getLocator()->get('Product\Model\AppealTable');
        $rowAppeal = $appealTable->getAppealById($appeal_id);

        //@todo Если у юзера уже было обращение к кредитному бюро за последние Setting{product} время и оно положительно то пропускать этот шаг А если нет ТО ЧТО??

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($formData['result'] == 1){

                return $this->redirect()->toRoute('default', array(
                    'controller' => 'client',
                    'action'     => 'step5',
                    'appeal' => $appeal_id
                ));

            } else {
                $data = array('status'=>2,'decline_reason'=>'Отклонено на этапе проверки кредитным бюро');
                $appealTable->update($data,'id = '.$rowAppeal['id']);
                //@todo $this->flashMessages
                return $this->redirect()->toRoute('home');
            }
        }


        //@todo Обращение к кредитному бюро
        //....
        $buroCheckTable = $this->getLocator()->get('Client\Model\BuroCheckTable');
        $data = array('client_id'=>$rowAppeal['client_id'],'answer'=>'');
        $buroCheckTable->insert($data);

        return array(
            'form' =>'',
            'appeal_id' => $appeal_id
        );
    }

    public function step5Action(){
        $appeal_id = $this->getRequest()->getMetadata('appeal', null);


        $appealTable = $this->getLocator()->get('Product\Model\AppealTable');
        $rowAppeal = $appealTable->getAppealById($appeal_id);
        $seviceClient = $this->getServiceClient();

        $section = $seviceClient::DATA_INFO_ALL;
        $dataAdditionalClient = $seviceClient->load($rowAppeal['client_id'])->getData('data');
        $dataClient = $dataAdditionalClient[$section];
        $newClientFlag = ( count($dataClient) == 0 ) ? true : false;

        $productTable = $this->getLocator()->get('Product\Model\ProductTable');
        $rowProduct = $productTable->getProductById($rowAppeal['product_id']);
        $clientFormSetting = json_decode($rowProduct['client_data'],true);


        $dop_form = array(
           // 'change_fio' => array('type'=>'Radio','label'=>'Менялись ли ФИО','displayGroup'=>'Основная информация'),
            'prev_fio' => array('type'=>'text','label'=>'Предыдущие ФИО','displayGroup'=>'Основная информация'),
            'city_birdth' => array('type'=>'text','label'=>'Место рождения','displayGroup'=>'Основная информация'),

            'tel_home' => array('type'=>'text','label'=>'Телефон домашний','displayGroup'=>'Контактные телефоны'),
            'tel_job' => array('type'=>'text','label'=>'Телефон мобильный','displayGroup'=>'Контактные телефоны'),

            'passport_series' => array('type'=>'text','label'=>'Серия','displayGroup'=>'Паспортные данные'),
            'passport_num' => array('type'=>'text','label'=>'Номер','displayGroup'=>'Паспортные данные'),
            'passport_series' => array('type'=>'text','label'=>'Кем выдан','displayGroup'=>'Паспортные данные'),
            'passport_date' => array('type'=>'text','label'=>'Дата выдачи','displayGroup'=>'Паспортные данные'),
            'passport_doc' => array('type'=>'text','label'=>'Второй документ','displayGroup'=>'Паспортные данные'),
            'passport_avtovaz' => array('type'=>'text','label'=>'Пропуск Автоваза','displayGroup'=>'Паспортные данные'),
            'passport_ip' => array('type'=>'text','label'=>'Свидетельство ИП','displayGroup'=>'Паспортные данные'),

            'date_reg' => array('type'=>'text','label'=>'Дата регистрации','displayGroup'=>'Дополнительная информация'),
            'status_home' => array('type'=>'text','label'=>'Статус жилья','displayGroup'=>'Дополнительная информация'),

            'adress_country' => array('type'=>'text','label'=>'Страна','displayGroup'=>'Адрес постоянной регистрации'),
            'adress_region' => array('type'=>'text','label'=>'Область','displayGroup'=>'Адрес постоянной регистрации'),
            'adress_city' => array('type'=>'text','label'=>'Населенный пункт','displayGroup'=>'Адрес постоянной регистрации'),
            'adress_street' => array('type'=>'text','label'=>'Улица','displayGroup'=>'Адрес постоянной регистрации'),
            'adress_house' => array('type'=>'text','label'=>'Дом','displayGroup'=>'Адрес постоянной регистрации'),
            'adress_build' => array('type'=>'text','label'=>'Строение','displayGroup'=>'Адрес постоянной регистрации'),
            'adress_flat' => array('type'=>'text','label'=>'Квартира','displayGroup'=>'Адрес постоянной регистрации'),
            'adress_zip' => array('type'=>'text','label'=>'Индекс','displayGroup'=>'Адрес постоянной регистрации'),

            //'adress2_aaa' => array('type'=>'text','label'=>'Совпадает с адресом постоянной регистрации','displayGroup'=>'Адрес фактического проживания'),
            'adress2_country' => array('type'=>'text','label'=>'Страна','displayGroup'=>'Адрес фактического проживания'),
            'adress2_region' => array('type'=>'text','label'=>'Область','displayGroup'=>'Адрес фактического проживания'),
            'adress2_city' => array('type'=>'text','label'=>'Населенный пункт','displayGroup'=>'Адрес фактического проживания'),
            'adress2_street' => array('type'=>'text','label'=>'Улица','displayGroup'=>'Адрес фактического проживания'),
            'adress2_house' => array('type'=>'text','label'=>'Дом','displayGroup'=>'Адрес фактического проживания'),
            'adress2_build' => array('type'=>'text','label'=>'Строение','displayGroup'=>'Адрес фактического проживания'),
            'adress2_flat' => array('type'=>'text','label'=>'Квартира','displayGroup'=>'Адрес фактического проживания'),
            'adress12_zip' => array('type'=>'text','label'=>'Индекс','displayGroup'=>'Адрес фактического проживания'),
            'adress123_zip' => array('type'=>'text','label'=>'Индекс','displayGroup'=>'Адрес фактического проживания'),
            'adress1234_zip' => array('type'=>'text','label'=>'Индекс','displayGroup'=>'Адрес фактического проживания'),
            'adress12345_zip' => array('type'=>'text','label'=>'Индекс','displayGroup'=>'Адрес фактического проживания'),


        );

        $options = array('form_constructor'=>array('form_name'=>'dop_data','elements'=>$dop_form));
        $options['form_constructor']['confirm'] = !$newClientFlag;

        $form = new \Client\Form\CustomizedForm($options);
        //Если клиент не новый то
        if (!$newClientFlag){
            $form->populate($dataClient);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                //@todo обновить данные по клиенту
                $values = $form->getValues();
                $seviceClient->updateData($values,true,$seviceClient::DATA_INFO_ALL);

                return $this->redirect()->toRoute('default', array(
                    'controller' => 'client',
                    'action'     => 'step6',
                    'appeal' => $appeal_id
                ));
            }

        }

        return array(
            'form' =>$form,
            'appeal_id' => $appeal_id
        );
    }

    public function step6Action(){
        $appeal_id = $this->getRequest()->getMetadata('appeal', null);
        $serviceClient = $this->getServiceClient();
        //@todo REFACTORING 2
        /**
         * @var $serviceAppeal \Product\Service\Appeal
         */
        $serviceAppeal = $this->getLocator()->get('Product\Service\Appeal');
        $rowAppeal = $serviceAppeal->load($appeal_id)->getData();
        $rowClient = $serviceAppeal->setServiceClient($serviceClient)->getClientData();


        // $appealTable = $this->getLocator()->get('Product\Model\AppealTable');
        //$rowAppeal = $appealTable->getAppealById($appeal_id);

        $productTable = $this->getLocator()->get('Product\Model\ProductTable');
        $rowProduct = $productTable->getProductById($rowAppeal['product_id']);

        //$serviceClient = $this->getServiceClient()->load($rowAppeal['client_id']);
        //$dataall = $serviceClient->getData('data');
        $client_data = json_decode($rowProduct['client_data'],true);
        $client_data_value = $rowClient['data'][$serviceClient::DATA_INFO_JOBS];
        $data_client = array();
        foreach ($client_data['forms'][$serviceClient::DATA_INFO_JOBS]['elements'] as $name => $elem){
            $data_client[] = array('name'=>$elem['label'],'value'=>$client_data_value[$name]);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if (isset($formData['result'])){
                //Если выбрано радиобокс - ОДОБРЕНО
                if ($formData['result'] == 1){

                    $serviceAppeal->getAppealTable()->update(array('status'=>1),'id = '.$rowAppeal['id']);
                    /**
                     * @var $serviceContract \Product\Service\Contract
                     */
                    $serviceContract = $this->getLocator()->get('service-contract');
                    $contract_id = $serviceContract->create($rowAppeal);

                    return $this->redirect()->toRoute('default', array(
                            'controller' => 'product',
                            'action'     => 'print',
                            'contract' => $contract_id
                        ));

                } else {

                    $data = array('status'=>2,'decline_reason'=>$formData['comment']);
                    $serviceAppeal->getAppealTable()->update($data,'id = '.$rowAppeal['id']);
                    //@todo $this->flashMessages
                    return $this->redirect()->toRoute('home');
                }
            }
        }

        return array(
            'form' =>'',
            'data_client'=>$data_client,
            'appeal_id' => $appeal_id
        );
    }


    public function indexAction(){
        return array(
            'form' =>'',
        );
    }

    /**
     * @param \Client\Service\Client $serviceClient
     */
    public function setServiceClient($serviceClient)
    {
        $this->serviceClient = $serviceClient;
    }

    /**
     * @return \Client\Service\Client
     */
    public function getServiceClient()
    {
        return $this->serviceClient;
    }


}