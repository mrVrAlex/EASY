<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 04.06.12
 * Time: 12:58
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Form;

use Zend\Form\Form,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory;

class MainInfoForm extends Form
{
    public function __construct()
    {

        parent::__construct();

        $this->setName('client_add');
        $this->setAttribute('method', 'post');

         // login
        $this->add(array(
            'name' => 'lastname',
            'attributes' => array(
                'type' => 'text',
                'label' => 'Фамилия:',
            ),
        ));

        $this->add(array(
            'name' => 'firstname',
            'attributes' => array(
                'type' => 'text',
                'label' => 'Имя:',
            ),
        ));

        $this->add(array(
            'name' => 'patronymic',
            'attributes' => array(
                'type' => 'text',
                'label' => 'Отчество:',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'label' => 'Получить отчет',
                'id' => 'submitbutton',
                'class'=>'button white'
            ),
        ));

        $this->setInputFilter($this->getCustomInputFilter());

    }

    public function getCustomInputFilter()
       {
               $inputFilter = new InputFilter();

               $factory = new InputFactory();

               $inputFilter->add($factory->createInput(array(
                   'name' => 'lastname',
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
                               'min' => 2,
                               'max' => 64,
                           ),
                       ),
                   ),
               )));

               $inputFilter->add($factory->createInput(array(
                   'name' => 'firstname',
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
                               'min' => 2,
                               'max' => 72,
                           ),
                       ),
                   ),
               )));

           $inputFilter->add($factory->createInput(array(
                              'name' => 'patronymic',
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
                                          'min' => 2,
                                          'max' => 72,
                                      ),
                                  ),
                              ),
                          )));

               return $inputFilter;
       }
}