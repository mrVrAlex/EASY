<?php
namespace AppUser\Form;

use Zend\Form\Form,
    Zend\Form\Element;

class LoginForm extends Form
{
    public function init()
    {
        //$this->setDisableLoadDefaultDecorators(true);
        $this->setName('login')
        ->clearDecorators();
            //->addDecorator('formElements');
            //->addDecorator('form');
        //$id = new Element\Hidden('id');
        //$id->addFilter('Int');

        $login = new Element\Text('login');
        $login->setLabel('Имя пользователя:')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('NotEmpty')
           // ->clearDecorators()
                ->addDecorator('Errors')
                ->addDecorator('Label', array('tag' => 'span'))
                            ->addDecorator('HtmlTag', array('tag' => 'div'));

        $password = new Element\Password('password');
        $password->setLabel('Пароль:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
            ->addDecorator('Errors')
             ->addDecorator('Label', array('tag' => 'span'))
                         ->addDecorator('HtmlTag', array('tag' => 'div'));

        $submit = new Element\Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('HtmlTag', array('tag' => 'div'));
         $submit->setAttrib('class', 'button white');
        $submit->setLabel('Войти');
        $this->addElements(array($login, $password, $submit));
    }
}
