<?php

namespace Core\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $this->layout()->messages = $this->flashMessenger()->getMessages();
        return new ViewModel();
    }
}
