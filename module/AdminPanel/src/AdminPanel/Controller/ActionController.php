<?php

namespace AdminPanel\Controller;

use Zend\Mvc\Controller;

class ActionController extends Controller\ActionController
{
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $events = $this->events();
        $events->attach('dispatch', array($this, 'preDispatch'), -1);
    }

    public function preDispatch($e){
        $renderer     = $this->getLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->layout('layout/admin');
    }
}