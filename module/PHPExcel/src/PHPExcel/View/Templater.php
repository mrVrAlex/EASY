<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 01.04.12
 * Time: 19:07
 * To change this template use File | Settings | File Templates.
 */
namespace PHPExcel\View;

class Templater {

    public function render($tplFile,array $vars, $replacer = false){
        $objPHPExcel = \PHPExcel_IOFactory::load($tplFile);
        $objPHPExcel->setActiveSheetIndex(0);
        foreach ($vars as $key => $var){
            if ($replacer){
                $str = $objPHPExcel->getActiveSheet()->getCell($key)->getValue();
                if (is_array($var)){
                    foreach ($var as $replace => $value){
                        $str = str_replace('{'.$replace.'}',$value,$str);
                    }
                }
            } else {
                $str = $var;
            }
            $objPHPExcel->getActiveSheet()->SetCellValue($key, $str);
        }
        return $objPHPExcel;
    }

    public function save($objPHPExcel,$saveFile,$output = false){

        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save($saveFile);

        if ($output){
            header('Content-type: application/ms-excel');
            header('Content-Disposition: attachment; filename='.$saveFile);
            return file_get_contents($saveFile);
        }

    }
}