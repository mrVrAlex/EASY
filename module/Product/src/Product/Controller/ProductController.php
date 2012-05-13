<?php

namespace Product\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class ProductController extends ActionController
{


    public function indexAction()
    {

        return new ViewModel();
    }

    public function printAction(){
        $contract_id = $this->getRequest()->getMetadata('contract', null);
        $save = $this->getRequest()->getMetadata('save', false);
        if ($contract_id && $save){
            $serviceContract = $this->getLocator()->get('service-contract')->load($contract_id);
            $dataContract = $serviceContract->getData();

            $serviceClient = $this->getLocator()->get('service-client')->load($dataContract['client_id']);
            $dataClient = $serviceClient->getData();
            $fio = $dataClient['lastname'] . ' ' . $dataClient['firstname'] . ' ' . $dataClient['patronymic'];
            //@todo refactor - change on abstract teplater
            $templater = new \PHPExcel\View\Templater();


            if ($save == 'dogovor'){

                $vars = array();
                $vars['A1'] = array('NUMBER'=>$dataContract['id']);
                $vars['A6'] = array('FIO'=>$fio);
                $vars['A29'] = array('FIO'=>$fio);
                //....@todo all fill varaible
                $obj = $templater->render('data/files/Dogovor.xls',$vars,true);
                echo $templater->save($obj,'data/files/'.$dataContract['fname'].'.xls',true);
                die();
            }

            if ($save == 'rko'){
                $dataRko = $serviceContract->printRKO();
                $vars = array();
                $vars['K10'] = array('DATE'=>$dataRko['till']['dt']);
                $vars['H10'] = array('NUMBER'=>$dataRko['till']['id']);
                $vars['H14'] = array('SUMMA'=>$dataRko['payment']['summa']);
                $vars['A16'] = array('FIO'=>$fio);
                $vars['A17'] = array('NUM_DOG'=>$dataContract['id'],'DATE_DOG'=>$dataContract['dt']);
                //....@todo all fill varaible
                $obj = $templater->render('data/files/rko.xls',$vars,true);
                echo $templater->save($obj,'data/files/'.$dataRko['till']['fname'].'.xls',true);
                die();

            }
        }
        /*
        if ($contract_id && $this->getRequest()->getMetadata('save', false)){


            $fio = $dataClient['lastname'] . ' ' . $dataClient['firstname'] . ' ' . $dataClient['patronymic'];

            $objPHPExcel = \PHPExcel_IOFactory::load('data/files/Dogovor.xls');
            $objPHPExcel->setActiveSheetIndex(0);

            $str = $objPHPExcel->getActiveSheet()->getCell('A1')->getValue();
            $str = str_replace('{NUMBER}',$dataContract['id'],$str);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', $str);

            $str = $objPHPExcel->getActiveSheet()->getCell('A6')->getValue();
            $str = str_replace('{FIO}',$fio,$str);
            $objPHPExcel->getActiveSheet()->SetCellValue('A6', $str);

            $str = $objPHPExcel->getActiveSheet()->getCell('A29')->getValue();
            $str = str_replace('{FIO}',$fio,$str);
            $objPHPExcel->getActiveSheet()->SetCellValue('A29', $str);


            //$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'world!');
            //$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Hello');
            //$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'world!');

            $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('data/files/'.$dataContract['fname'].'.xls');
            header('Content-type: application/ms-excel');
            header('Content-Disposition: attachment; filename='.'data/files/'.$dataContract['fname'].'.xls');
            echo file_get_contents('data/files/'.$dataContract['fname'].'.xls');
            die();
        }


        // Create new PHPExcel object

        $objPHPExcel = \PHPExcel_IOFactory::load('data/files/Dogovor.xls');

        // Set properties
        echo date('H:i:s') . " Set properties\n";
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
        $objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");


        // Add some data
        echo date('H:i:s') . " Add some data\n";
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'world!');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Hello');
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'world!');

        // Rename sheet
        echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


        // Save Excel 2007 file
        echo date('H:i:s') . " Write to Excel2007 format\n";
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('data/files/exel1.xlsx');

        $objPHPExcel->setActiveSheetIndex(0);
        $aSheet = $objPHPExcel->getActiveSheet();
        $t = '<table cellpadding="0" cellspacing="0">';
        //получим итератор строки и пройдемся по нему циклом
        foreach($aSheet->getRowIterator() as $row){
        $t .= "<tr>\r\n";
        //получим итератор ячеек текущей строки
        $cellIterator = $row->getCellIterator();
        //пройдемся циклом по ячейкам строки
        foreach($cellIterator as $cell){
        //и выведем значения
            $t .= "<td>".$cell->getCalculatedValue()."</td>";
        }
            $t .= "<tr>\r\n";
        }
        $t .= '</table>';
        //echo $t; */

        return array(
            'form' => '',
            'contract_id'=>$contract_id
        );
    }


}