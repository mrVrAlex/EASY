<?php
namespace Client\Form;

use Client\Form\Element as CElement,
    Zend\Form\Form,
    Zend\Form\Element,
    Zend\Dojo\Dojo as Dojo,
    Zend\Dojo\Form\Element as DojoElement;


class AddForm extends Form
{
    public function init()
    {
        //Dojo::enableForm($this);
        $this->setName('client_add');

        //$this->setDecorators(array(
                 //'Form',
        //        'FormElements',
        //         array('HtmlTag', array('tag' => 'dl')),
       //        'ContentPane',
        //));

        $id = new Element\Hidden('product_id');
        $id->addFilter('Int');

        $lastname = new Element\Text('lastname');
        $lastname = $this->addTextMethods($lastname->setLabel('Фамилия:'));
        //$lastname->addDecorator('Errors',array('placement' => 'PREPEND'));
        $firstname = new Element\Text('firstname');
        $firstname = $this->addTextMethods($firstname->setLabel('Имя:'));

        $patronymic = new Element\Text('patronymic');
        $patronymic = $this->addTextMethods($patronymic->setLabel('Отчество:'));

        $birthday = new CElement\Birthdate('birthdate'); //Element\Text('birthdate');
        $birthday = $birthday->setLabel('Дата рождения:');//$this->addTextMethods($birthday->setLabel('Дата рождения:'));
        $birthday->addValidator('Date');

        $passport = new CElement\Passport('passport');
        $passport->setLabel('Паспорт:')
                 ->setValue(array('ser' => 'серия',
                                      'num' => 'номер',
                                      'country' => 'страна/город',
                                      'date' => 'Дата выдачи',
                                      'authority' => 'Кем выдан'
                         ));

        $address_reg = new CElement\Address('address_reg');
        $address_reg->setLabel('Адрес регистрации:')
                    ->setValue(array('city' => 'город',
                                         'str' => 'улица',
                                         'house' => 'дом',
                                         'flat' => 'квартира',
                                        // 'authority' => $this->getAuthority()
                            ));

        $address_real = new CElement\Address('address_real');
        $address_real->setLabel('Адрес проживания:')
                    ->setValue(array('city' => 'город',
                                         'str' => 'улица',
                                         'house' => 'дом',
                                         'flat' => 'квартира',
                                        // 'authority' => $this->getAuthority()
                            ));


        $amount = new Element\Select('loan_amount');
        $amount->setOptions(array(
            'label'        => 'Сумма займа:',
            'value'        => '1000',
            'autocomplete' => false,
            'multiOptions' => array(
                '1000'    => '1000 рублей',
                '2000'   => '2000 рублей',
                '3000'  => '3000 рублей',
                '4000' => '4000 рублей',
                '5000'  => '5000 рублей',
                '6000'  => '6000 рублей',
            ),
        ))->setRequired(true)
            ->clearDecorators()
         ->addDecorator('ViewHelper')
            ->addDecorator('Errors')
;


        $term = new Element\Select('loan_term');
        $term->setOptions(array(
            'label'        => 'Срок займа:',
            'value'        => '1',
            'autocomplete' => false,
            'multiOptions' => array(
                '1'    => '1 день',
                '2'   => '2 день',
                '3'  => '3 день',
                '4' => '4 день',
                '5'  => '5 день',
                '6'  => '6 день',
            ),
        ))->setRequired(true)
            ->clearDecorators()
         ->addDecorator('ViewHelper')
            ->addDecorator('Errors')
;
        
        /*
        $title = new Element\Text('title');
        $title->setLabel('Title')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        */
        $submit = new Element\Submit('submit');
        $submit->setAttrib('id', 'submitbutton')->setAttrib('class', 'button white');
        $submit->setLabel('Получить отчет')
            ->clearDecorators()
         ->addDecorator('ViewHelper')
            ->addDecorator('Errors')
;

        $this->addElements(array($id,$lastname,$firstname,$patronymic,$birthday, $passport, $address_reg, $address_real, $amount, $term, $submit));
    }

    protected function addTextMethods($elem) {
         $elem->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('StringLength',false,array('min' => 1, 'max' => 30,'encoding'=>'utf-8'))
                ->clearDecorators()
             ->addDecorator('ViewHelper')
                ->addDecorator('Errors')
;
        return $elem;
                //->addDecorator('HtmlTag', array('tag' => 'dd'))
                //->addDecorator('Label', array('tag' => 'dt'));
    }
}
