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

class Address extends Xhtml {

    //protected $_dateFormat = '%year%-%month%-%day%';
    protected $_city;
    protected $_str;
    protected $_house;
    protected $_flat;
    //protected $_authority;

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
                 ->addDecorator('Address')
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

    public function setCity($value)
    {
        $this->_city = $value;
        return $this;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function setStr($value)
    {
        $this->_str = $value;
        return $this;
    }

    public function getStr()
    {
        return $this->_str;
    }

    public function setHouse($value)
    {
        $this->_house = $value;
        return $this;
    }

    public function getHouse()
    {
        return $this->_house;
    }

    public function setValue($value)
    {
        if (is_array($value)
                  && (isset($value['city'])
                      && isset($value['str'])
                      && isset($value['house'])
                      && isset($value['flat'])
                     // && isset($value['authority'])
                  )
        ) {
            $this->setCity($value['city'])
                 ->setStr($value['str'])
                 ->setHouse($value['house'])
                 ->setFlat($value['flat']);
                // ->setAuthority($value['authority']);
        } else {
            throw new Form\Exception\InvalidArgumentException('Invalid date value provided');
        }

        return $this;
    }

    public function getValue()
    {
        return array('city' => $this->getCity(),
                     'str' => $this->getStr(),
                     'house' => $this->getHouse(),
                     'flat' => $this->getFlat(),
                    // 'authority' => $this->getAuthority()
        );
    }

    public function setFlat($date)
    {
        $this->_flat = $date;
        return $this;
    }

    public function getFlat()
    {
        return $this->_flat;
    }

    public function setAuthority($authority)
    {
        //$this->_authority = $authority;
        return $this;
    }

    public function getAuthority()
    {
        return $this->_authority;
    }


}