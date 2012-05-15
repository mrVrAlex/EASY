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

    public function indexAction(){
        return new ViewModel();
    }
    public function step1Action(){
        $product_id = $this->getRequest()->getMetadata('product', 1);
        $form = new \Client\Form\AddForm();
        $form->product_id->setValue($this->_productId);
        return new ViewModel(array('formClient'=>$form));
    }
}