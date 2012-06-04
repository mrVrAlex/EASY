<?php

namespace Product\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Core\Module as App;

class CreditController extends ActionController
{
    protected $_steps = array('step1',
                              'step2');
    protected $_productId = 0;

    protected function init(){
        //@todo initialized session and set product id which findByAlias
    }

    protected function getFormAttrByStep($nameStep){
        $modelForm = $this->getLocator()->get('model-form');
        $modelForm->getCollection()->addFilterToField(array('key'=>$nameStep))->load()->current();
        $attr = $modelForm->getAttributes();
        return $attr;
    }

    public function indexAction(){
        return new ViewModel();
    }
    public function step1Action(){
        //$product_id = $this->getRequest()->getMetadata('product', 1);
        $modelClient = App::getModel('Client/Client');
        $form = new \Client\Form\MainInfoForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->post());
            if ($form->isValid()) {
                $modelClient->populate($form->getData());
                $modelClient->setBirthdate('2012-06-11');
                $modelClient->setData('data',' ');
                $modelClient->setUserId(1);
                $modelClient->setBranchId(1);
                $modelClient->save();
                return $this->redirect()->toRoute('product', array(
                                    'controller' => 'credit',
                                    'action'     => 'step2',
                                    'appeal' => 1
                                ));
            }
        }
        //$data = $modelClient->load(6);
        //$serviceClient = $this->getLocator()->get('service-client');
        //$data = $serviceClient->test();
        //$form = new \Client\Form\AddForm();
        //$form->product_id->setValue($this->_productId);
        return new ViewModel(array('formClient'=>$form,'dataTest'=>''));
    }

    public function step2Action(){

        //$attrForm = $this->getFormAttrByStep($this->_steps[1]);
        //$serviceClient = $this->getLocator()->get('service-client');
        //$attrClient = $serviceClient->getAttributes()->getCollection()->addFilterToField(array('attribute_id'=>$attrForm));
        //$form = \Product\Form\CustomizedForm::createFormByAtrr($attrClient);
        //if (true){
        //    $form->isFillFields(true);
        //    $form->populate();
        //}
        if ($this->getRequest()->isPost()) {
        //    $formData = $this->getRequest()->post()->toArray();
        //    if ($form->isValid($formData)) {
        //        $values = $form->getValues();
        //        $serviceClient->updateData($values);
                return $this->redirect()->toRoute('product', array(
                    'controller' => 'credit',
                    'action'     => 'step3',
                    'appeal' => 1
                ));
        //    }

        }
        return new ViewModel(array('formClient'=>''));
    }

    public function step3Action(){
        if ($this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('product', array(
                                'controller' => 'credit',
                                'action'     => 'step4',
                                //'appeal' => 1
                            ));
        }
        return new ViewModel();
    }

    public function step4Action(){
        if ($this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('product', array(
                                'controller' => 'credit',
                                'action'     => 'step5',
                                //'appeal' => 1
                            ));
        }
        return new ViewModel();
    }

    public function step5Action(){
        if ($this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('product', array(
                                'controller' => 'credit',
                                'action'     => 'step6',
                                //'appeal' => 1
                            ));
        }
        return new ViewModel();
    }

    public function step6Action(){
        if ($this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('product', array(
                                'controller' => 'credit',
                                'action'     => 'step7',
                                //'appeal' => 1
                            ));
        }
        return new ViewModel();
    }
}