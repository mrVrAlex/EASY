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

class Birthdate extends AbstractDecorator
{
    protected $years;
    protected $months;
    protected $days;

    public function __construct($options = null){
        setlocale(LC_ALL,"rus");
        setlocale(LC_ALL,"rus.1251");
        setlocale(LC_ALL,NULL);
        $y = range(1950,2000);
        $m = range(1,12);
        $ml = $m;
        //@todo change to unix style
        array_walk($ml,function(&$item,$key){ $item = mb_convert_encoding(strftime('%B',mktime(1,1,1,$item,1,2000)),'UTF-8','windows-1251');});
        $d = range(1,31);
        $this->years = array_combine($y,$y);
        $this->months = array_combine($m,$ml);
        $this->days = array_combine($d,$d);
        parent::__construct($options);
    }

    public function render($content)
    {
        /**
         * @var $element \Client\Form\Element\Birthdate
         */
        $element = $this->getElement();
        if (!$element instanceof Element\Birthdate) {
            // only want to render Date elements
            return $content;
        }

        $view = $element->getView();
        if ($view === null) {
            // using view helpers, so do nothing if no view present
            return $content;
        }

        $day   = $element->getDay();
        $month = $element->getMonth();
        $year  = $element->getYear();
        $name  = $element->getFullyQualifiedName();

        $params = array(
            //'class'=>'alter',
           // 'style'=>'width: 100px',
           // 'maxlength' => 2,
        );
        $yearParams = array(
           // 'size'      => 4,
           // 'maxlength' => 4,
        );

        $markup = $view->formSelect($name . '[day]', $day, $params,$this->days )
                . ' ' . $view->formSelect($name . '[month]', $month, $params, $this->months )
                . ' ' . $view->formSelect($name . '[year]', $year, $params, $this->years );

        switch ($this->getPlacement()) {
            case self::PREPEND:
                return $markup . $this->getSeparator() . $content;
            case self::APPEND:
            default:
                return $content . $this->getSeparator() . $markup;
        }
    }
}