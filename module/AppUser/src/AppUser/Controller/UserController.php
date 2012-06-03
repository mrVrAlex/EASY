<?php

namespace AppUser\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    AppUser\Model\UserTable,
    AppUser\Form\LoginForm;

class UserController extends ActionController
{
    /**
     * @var \AppUser\Model\UserTable
     */
    protected $userTable;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        $form = new LoginForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->post());
            $form->setInputFilter($form->getCustomInputFilter());
            if ($form->isValid()) {
                $data = $form->getData();
                $authAdapter = $this->_getAuthAdapter($data['login'], $data['password']);
                $result = $this->getServiceLocator()->get('auth-service')->authenticate($authAdapter);
                if (!$result->isValid()) {
                    $form->setMessages(array('password'=>array('Wrong combination of username and password')));//addError('Wrong combination of username and password');
                } else {
                    $userModel = \Core\Module::getModel('AppUser/User');
                    $identity = $authAdapter->getResultRowObject(null, 'password');
                    $identity = $userModel->load($identity->id);
                    $this->getServiceLocator()->get('auth-service')->getStorage()->write($identity);
                    $this->flashMessenger(array())->addMessage('Спасибо, <strong>'.$identity->getData('login').'</strong>, вы успешно вошли в систему!');
                    return $this->redirect()->toRoute('home');
                }
            }
        }
      return new ViewModel(array('form' => $form));
    }

    protected function _getAuthAdapter($login, $password)
    {
        $dbAdapter = $this->getServiceLocator()->get('db-config');
	    $authAdapter = new \Zend\Authentication\Adapter\DbTable($dbAdapter);
	    $authAdapter->setTableName('users')
			->setIdentityColumn('login')
			->setCredentialColumn('password')
			->setCredentialTreatment('MD5(?)')
			->setIdentity($login)
			->setCredential($password);
        return $authAdapter;
    }

    public function logoutAction()
    {
        $this->getServiceLocator()->get('auth-service')->clearIdentity();
        $this->redirect(array())->toRoute('default',array('action' => 'login', 'controller'=>'user'));
        return new \Zend\View\Model\JsonModel(array());
    }
}