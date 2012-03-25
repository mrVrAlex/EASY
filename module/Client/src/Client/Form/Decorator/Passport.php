<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 22.03.12
 * Time: 22:19
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Form\Decorator;

use Client\Form\Element,
    Zend\Form\Decorator\AbstractDecorator;

class Passport extends AbstractDecorator
{
    public function render($content)
    {
        /**
         * @var $element \Client\Form\Element\Passport
         */
        $element = $this->getElement();
        if (!$element instanceof Element\Passport) {
            // only want to render Date elements
            return $content;
        }

        $view = $element->getView();
        if ($view === null) {
            // using view helpers, so do nothing if no view present
            return $content;
        }

        $ser   = $element->getSer();
        $num = $element->getNum();
        $country  = $element->getCountry();
        $date  = $element->getDate();
        $authority  = $element->getAuthority();
        $name  = $element->getFullyQualifiedName();

        $params = array(
            'class'=>'alter',
            'style'=>'width: 100px',
           // 'maxlength' => 2,
        );
        $yearParams = array(
           // 'size'      => 4,
           // 'maxlength' => 4,
        );

        $markup = $view->formText($name . '[ser]', $ser, $params)
                . ' ' . $view->formText($name . '[num]', $num, $params + array('size'=>6,'maxlength' => 6))
                . ' ' . $view->formText($name . '[country]', $country, $params)
                . ' ' . $view->formText($name . '[date]', $date, $params)
                . ' ' . $view->formText($name . '[authority]', $authority, $params);

        switch ($this->getPlacement()) {
            case self::PREPEND:
                return $markup . $this->getSeparator() . $content;
            case self::APPEND:
            default:
                return $content . $this->getSeparator() . $markup;
        }
    }
}