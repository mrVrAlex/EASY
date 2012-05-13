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
        return array(
            'albums' => $this->userTable->fetchAll(),
        );
    }

    public function loginAction()
    {
      $form = new LoginForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $login = $form->getValue('login');
                $password  = $form->getValue('password');

            $authAdapter = $this->_getAuthAdapter($login, $password);
            $result = $this->getLocator()->get('auth-service')->authenticate($authAdapter);
            if (!$result->isValid()) {
                $form->setDecorators(array('Errors', 'FormElements', 'FormDecorator'));
                $form->addError('Wrong combination of username and password');
            } else {
                $userModel = $this->getLocator()->get('AppUser\Model\UserTable');
                $identity = $authAdapter->getResultRowObject(null, 'password');
                $identity = $userModel->getUserInfo($identity->id);
                $this->getLocator()->get('auth-service')->getStorage()->write($identity);

                $this->flashMessenger(array())->addMessage('You are successful logged!');
                // Redirect to list of albums
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'index',
                    'action'     => 'index',
                ));
            }


            }
        }

      return new ViewModel(array('form' => $form));
    }

    protected function _getAuthAdapter($login, $password)
    {
       $dbAdapter = $this->getLocator()->get('db-config');
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
        $this->getLocator()->get('auth-service')->clearIdentity();
        $this->redirect(array())->toRoute('default',array('action' => 'login', 'controller'=>'user'));
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->submit->setLabel('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $artist = $form->getValue('artist');
                $title  = $form->getValue('title');
                $this->albumTable->addAlbum($artist, $title);

                // Redirect to list of albums
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'album',
                    'action'     => 'index',
                ));

            }
        }

        return array('form' => $form);

    }

    public function editAction()
    {
        $form = new AlbumForm();
        $form->submit->setLabel('Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $id     = $form->getValue('id');
                $artist = $form->getValue('artist');
                $title  = $form->getValue('title');
                
                if ($this->albumTable->getAlbum($id)) {
                    $this->albumTable->updateAlbum($id, $artist, $title);
                }

                // Redirect to list of albums
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'album',
                    'action'     => 'index',
                ));
            }
        } else {
            $id = $request->query()->get('id', 0);
            if ($id > 0) {
                $form->populate($this->albumTable->getAlbum($id));
            }
        }

        return array('form' => $form);
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->post()->get('del', 'No');
            if ($del == 'Yes') {
                $id = $request->post()->get('id');
                $this->albumTable->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('default', array(
                    'controller' => 'album',
                    'action'     => 'index',
                ));
        }

        $id = $request->query()->get('id', 0);
        return array('album' => $this->albumTable->getAlbum($id));        
    }

    public function setAlbums(UserTable $userTable)
    {
        $this->userTable = $userTable;
        return $this;
    }    
}