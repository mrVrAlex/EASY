<?php

namespace AppUser\Plugin;

use \Zend\Authentication\AuthenticationService,
     \Zend\EventManager\StaticEventManager;

class Auth
{
    protected $app;
/**
* Return application authentification service
* @return \Zend\Authentication\AuthenticationService
*/
    public function getAuthentificationService()
    {
        return $this->_auth;
    }

    public function setAuthentificationService()
    {
        return $this->_auth;
    }

    public function __construct($authenticationService = null)
    {
        if(empty($authenticationService))
            $this->_auth = new AuthenticationService();
        else {
		if ($authenticationService instanceof AuthenticationService){
			$this->_auth = $authenticationService;
		} else {
			throw new \Zend\Exception('sopa!');
		}
	}

    }

    public function routeShutdown(\Zend\Mvc\MvcEvent $event)
    {
        if($this->getAuthentificationService()->hasIdentity()) {
            //$roleName = $this->getAuthentificationService()->getIdentity()->getRole()->getName();
            //if (!empty($roleName)) {
            //    $this->getAcl()->setCurrentRole(new \Zend\Acl\Role\GenericRole($roleName));
            //}
		return;
        }
        
        // \Zend\View\Helper\Navigation\AbstractHelper::setDefaultRole($this->getAcl()->getCurrentRole());
        
        $locator = $event->getTarget()->getLocator();
        //if($locator->instanceManager()->hasAlias('sysmap-service')) {
            //$currentResource = $locator->get('sysmap-service')->getIdentifierByRequest($event->getRouteMatch());

            $allow = false;
            //if($currentResource instanceof \Zend\Acl\Resource\GenericResource) {
            //    $allow = $this->getAcl()->isAllowed($this->getAcl()->getCurrentRole(), $currentResource);
            //}

            if(!$allow) {

                $controller = $event->getRouteMatch()->getParam('controller');
                $action = $event->getRouteMatch()->getParam('action');
                $foundController = $event->getTarget()->getLocator()->instanceManager()->hasAlias($controller);
                $foundAction = false;

                if($foundController) {
                    $controllerInstance = $event->getTarget()->getLocator()->get($controller);
                    $method = \Zend\Mvc\Controller\ActionController::getMethodFromAction($action);
                    if (method_exists($controllerInstance, $method)) {
                        $foundAction = true;
                    }
                }

                if($foundAction) {
                    $event->getRouteMatch()->setParam('controller','user');
                    $event->getRouteMatch()->setParam('action','login');
                }
            }
        //}
    }

    public function setApplication(\Zend\Mvc\AppContext $app)
    {
        $this->app = $app;
    }
    
    protected function getApplication()
    {
        return $this->app;
    }
}