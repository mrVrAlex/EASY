<?php
namespace AppUser\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory;


class LoginForm extends Form
{
    protected $inputFilter;

    public function __construct()
    {

        parent::__construct();

        $this->setName('login');
        $this->setAttribute('method', 'post');

         // login
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'text',
                'label' => 'Имя пользователя:',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'text',
                'label' => 'Пароль:',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'label' => 'Войти',
                'id' => 'submitbutton',
                'class'=>'button white'
            ),
        ));
/*
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
        $this->addElements(array($login, $password, $submit));*/
    }

    public function getCustomInputFilter()
       {
           if (!$this->inputFilter) {
               $inputFilter = new InputFilter();

               $factory = new InputFactory();

               $inputFilter->add($factory->createInput(array(
                   'name' => 'login',
                   'required' => true,
                   'filters' => array(
                       array('name' => 'StripTags'),
                       array('name' => 'StringTrim'),
                   ),
                   'validators' => array(
                       array(
                           'name' => 'StringLength',
                           'options' => array(
                               'encoding' => 'UTF-8',
                               'min' => 3,
                               'max' => 64,
                           ),
                       ),
                   ),
               )));

               $inputFilter->add($factory->createInput(array(
                   'name' => 'password',
                   'required' => true,
                   'filters' => array(
                       array('name' => 'StripTags'),
                       array('name' => 'StringTrim'),
                   ),
                   'validators' => array(
                       array(
                           'name' => 'StringLength',
                           'options' => array(
                               'encoding' => 'UTF-8',
                               'min' => 4,
                               'max' => 72,
                           ),
                       ),
                   ),
               )));

               $this->inputFilter = $inputFilter;
           }

           return $this->inputFilter;
       }
}
