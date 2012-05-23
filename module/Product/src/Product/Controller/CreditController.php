<?php

namespace Product\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

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
        $product_id = $this->getRequest()->getMetadata('product', 1);

        $serviceClient = $this->getLocator()->get('service-client');
        $data = $serviceClient->test();
        $form = new \Client\Form\AddForm();
        $form->product_id->setValue($this->_productId);
        return new ViewModel(array('formClient'=>$form,'dataTest'=>$data));
    }

    public function step2Action(){

        $attrForm = $this->getFormAttrByStep($this->_steps[1]);
        $serviceClient = $this->getLocator()->get('service-client');
        $attrClient = $serviceClient->getAttributes()->getCollection()->addFilterToField(array('attribute_id'=>$attrForm));
        $form = \Product\Form\CustomizedForm::createFormByAtrr($attrClient);
        if (true){
            $form->isFillFields(true);
            $form->populate();
        }
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->post()->toArray();
            if ($form->isValid($formData)) {
                $values = $form->getValues();
                $serviceClient->updateData($values);
                return $this->redirect()->toRoute('default11111', array(
                    'controller' => 'credit',
                    'action'     => 'step3',
                    'appeal' => 1
                ));
            }

        }
        return new ViewModel(array('formClient'=>$form));
    }
}