<?php
namespace Client\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Dojo\Dojo as Dojo,
    Zend\Dojo\Form\Element as DojoElement;


class CustomizedForm extends Form
{
    protected $form_constructor;

    public function __construct($options = null){
        $this->form_constructor = $options['form_constructor'];
        unset($options['form_constructor']);
        parent::__construct($options);
    }


    public function init()
    {
        //Dojo::enableForm($this);
        $this->setName($this->form_constructor['form_name']);
        $confirm = $this->form_constructor['confirm'];
        //$this->setDecorators(array(
                 //'Form',
        //        'FormElements',
        //         array('HtmlTag', array('tag' => 'dl')),
       //        'ContentPane',
        //));

        $id = new Element\Hidden('id');
        $id->addFilter('Int');
        $this->addElement($id);
        //$t
        $display_group = array();

        foreach ($this->form_constructor['elements'] as $name => $option){
            $element_name = 'Zend\Form\Element\\'.ucfirst($option['type']).'';
            $elem = new $element_name($name);
            $elem->clearDecorators();
            $elem = $this->addTextMethods($elem->setLabel(ucfirst($option['label']).':'),$confirm);
            $this->addElement($elem);

            if (isset($option['displayGroup'])){
                $display_group[$option['displayGroup']][] = $name;
                //$display_group[$option['displayGroup']][]['name'][] = $option['displayGroup'];
                //$display_group[$option['displayGroup']][]['options'] = array('legend'=>$option['displayGroup']);
            }
        }

        if (count($display_group)>0){
            foreach ($display_group as $name => $val){
                $groups[] = array($val,$name,array('legend'=>$name));
            }

            $this->addDisplayGroups($groups);
        }

        if (count($this->form_constructor['elements']) == 0){
            $messages = new DojoElement\TextBox('messages');
            $messages->setAttrib('disabled', 'disabled');
            $messages->setAttrib('style', 'width:200px;');
            $messages->setValue('Дополнительные данные отсутствуют.');
            $this->addElement($messages);
        }

        /*
        $lastname = new DojoElement\TextBox('org_name');
        $lastname->add
        //$lastname->setOptions(array(
        //    'label'          => 'ValidationTextBox',
        //    'required'       => true,
        //    'regExp'         => '[\w]+',
        //    'invalidMessage' => 'Invalid non-space text.',
        //));
        $lastname = $this->addTextMethods($lastname->setLabel('Название организации:'));

        $firstname = new DojoElement\TextBox('position');
        $firstname = $this->addTextMethods($firstname->setLabel('Должность:'));

        $patronymic = new DojoElement\NumberTextBox('salary');
        $patronymic = $this->addTextMethods($patronymic->setLabel('Оклад:'));

        $orgphone = new DojoElement\TextBox('org_phone');
        $orgphone = $this->addTextMethods($orgphone->setLabel('Рабочий телефон:'));

        $bossname = new DojoElement\TextBox('boss_name');
        $bossname = $this->addTextMethods($bossname->setLabel('Имя руководителя:'));
        */
        $submit = new Element\Submit('submit'); //DojoElement\SubmitButton('submit');
        $submit->setAttrib('id', 'submitbutton')->setAttrib('class', 'button white');
        if ($confirm) {
            $submit->setAttrib('disabled', 'disabled');
        }
        $submit->setLabel('Далее');
        $this->addElement($submit);

        //$this->addElements($elements); //array($id,$lastname,$firstname,$patronymic, $orgphone, $bossname, $submit)
    }

    protected function addTextMethods($elem,$confirm = false) {
         $elem->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('StringLength',false,array('min' => 2, 'max' => 50))
                ->addDecorator('ViewHelper');
        if ($confirm) {
            $elem->addDecorator('Callback',array('callback'=>$this->test(),'placement'=>'APPEND'));
            $elem->setOptions(array('class'=>'hidden'));
        }

               // ->addDecorator('Callback',array('callback'=>$this->test(),'placement'=>'APPEND'))
                $elem->addDecorator('Errors')
                ->addDecorator('HtmlTag', array('tag' => 'div'))
                ->addDecorator('Label', array('tag' => 'span'));
return $elem;
    }

    protected function test(){
        return function($content,$el,$opt){
            $t = '<div><span>'.$el->getValue().'</span>
                <a href="#">Изменить</a> &nbsp;&nbsp; <a href="#" class="confirm">Подтвердить</a>
                <input name="check" type="checkbox" id="check" /></div>';
            return $t;
        };
    }
}
