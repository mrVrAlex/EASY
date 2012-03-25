<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 22.03.12
 * Time: 21:32
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Form\Element;

    use Zend\Form,
        Zend\Form\Element,
        Zend\Form\Element\Xhtml;

class Birthdate extends Xhtml {

    protected $_dateFormat = "%04d-%02d-%02d";
    protected $_day;
    protected $_month;
    protected $_year;

    public function __construct($spec, $options = null)
    {
        $this->addPrefixPath('Client\Form\Decorator','Client/Form/Decorator','decorator');
        parent::__construct($spec, $options);
    }

    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this//->addDecorator('ViewHelper')
                 ->addDecorator('Birthdate')
                 ->addDecorator('Errors');
                 //->addDecorator('Description', array(
                 //    'tag'   => 'p',
                 //    'class' => 'description'
                 //))
                // ->addDecorator('HtmlTag', array(
                //     'tag' => 'dd',
                //     'id'  => $this->getName() . '-element'
                // ))
                // ->addDecorator('Label', array('tag' => 'dt'));
        }
    }

    public function setDay($value)
    {
        $this->_day = $value;
        return $this;
    }

    public function getDay()
    {
        return $this->_day;
    }

    public function setMonth($value)
    {
        $this->_month = $value;
        return $this;
    }

    public function getMonth()
    {
        return $this->_month;
    }

    public function setYear($value)
    {
        $this->_year = $value;
        return $this;
    }

    public function getYear()
    {
        return $this->_year;
    }

    public function setValue($value)
    {
        if (is_int($value)) {
            $this->setDay(date('d', $value))
                 ->setMonth(date('m', $value))
                 ->setYear(date('Y', $value));
        } elseif (is_string($value)) {
            $date = strtotime($value);
            $this->setDay(date('d', $date))
                 ->setMonth(date('m', $date))
                 ->setYear(date('Y', $date));
        } elseif (is_array($value)
                  && (isset($value['day'])
                      && isset($value['month'])
                      && isset($value['year'])
                  )
        ) {
            $this->setDay($value['day'])
                 ->setMonth($value['month'])
                 ->setYear($value['year']);
        } else {
            throw new Exception('Invalid date value provided');
        }
        return $this;
    }

    public function getValue()
    {
        return sprintf($this->_dateFormat,$this->getYear(), $this->getMonth(), $this->getDay());
    }


}