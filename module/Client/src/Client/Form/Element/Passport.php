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

class Passport extends Xhtml {

    //protected $_dateFormat = '%year%-%month%-%day%';
    protected $_ser;
    protected $_num;
    protected $_country;
    protected $_date;
    protected $_authority;

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
                 ->addDecorator('Passport')
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

    public function setSer($value)
    {
        $this->_ser = $value;
        return $this;
    }

    public function getSer()
    {
        return $this->_ser;
    }

    public function setNum($value)
    {
        $this->_num = $value;
        return $this;
    }

    public function getNum()
    {
        return $this->_num;
    }

    public function setCountry($value)
    {
        $this->_country = $value;
        return $this;
    }

    public function getCountry()
    {
        return $this->_country;
    }

    public function setValue($value)
    {
        if (is_array($value)
                  && (isset($value['ser'])
                      && isset($value['num'])
                      && isset($value['country'])
                      && isset($value['date'])
                      && isset($value['authority'])
                  )
        ) {
            $this->setSer($value['ser'])
                 ->setNum($value['num'])
                 ->setCountry($value['country'])
                 ->setDate($value['date'])
                 ->setAuthority($value['authority']);
        } else {
            throw new Form\Exception\InvalidArgumentException('Invalid date value provided');
        }

        return $this;
    }

    public function getValue()
    {
        return array('ser' => $this->getSer(),
                     'num' => $this->getNum(),
                     'country' => $this->getCountry(),
                     'date' => $this->getDate(),
                     'authority' => $this->getAuthority()
        );
    }

    public function setDate($date)
    {
        $this->_date = $date;
        return $this;
    }

    public function getDate()
    {
        return $this->_date;
    }

    public function setAuthority($authority)
    {
        $this->_authority = $authority;
        return $this;
    }

    public function getAuthority()
    {
        return $this->_authority;
    }


}