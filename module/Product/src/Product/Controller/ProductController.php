<?php

namespace Product\Controller;

use Zend\Mvc\Controller\ActionController;
//    Album\Model\AlbumTable,
//    Album\Form\AlbumForm;

class ProductController extends ActionController
{


    public function indexAction()
    {
        /*
        $form = new \Zend\Form\Form();
        \Zend\Dojo\Dojo::enableForm($form);

        $form->setDecorators(array(
    'FormElements',
    array('TabContainer', array(
        'id'          => 'tabContainer',
        'style'       => 'width: 800px; height: 700px;',
        'dijitParams' => array(
            'tabPosition' => 'top'
        ),
    )),
    'DijitForm',
));
            $form->addElement(
        'TextBox',
        'foo',
        array(
            'value'      => 'some text',
            'label'      => 'TextBox',
            'trim'       => true,
            'propercase' => true,
        )
    );
            $form->addElement(
        'ValidationTextBox',
        'foo',
        array(
            'label'          => 'ValidationTextBox',
            'required'       => true,
            'regExp'         => '[\w]+',
            'invalidMessage' => 'Invalid non-space text.',
        )
    );

                    $form->addElement(
        'ComboBox',
        'foo',
        array(
            'label'        => 'ComboBox (select)',
            'value'        => 'blue',
            'autocomplete' => false,
            'multiOptions' => array(
                'red'    => 'Rouge',
                'blue'   => 'Bleu',
                'white'  => 'Blanc',
                'orange' => 'Orange',
                'black'  => 'Noir',
                'green'  => 'Vert',
            ),
        )
    );

        $form->addElement(
                'TextBox',
                'textbox',
                array(
                    'value'      => 'some text',
                    'label'      => 'TextBox',
                    'trim'       => true,
                    'propercase' => true,
                )
            )
            ->addElement(
                'DateTextBox',
                'datebox',
                array(
                    'value' => '2008-07-05',
                    'label' => 'DateTextBox',
                    'required'  => true,
                )
            )
            ->addElement(
                'TimeTextBox',
                'timebox',
                array(
                    'label' => 'TimeTextBox',
                    'required'  => true,
                )
            )
            ->addElement(
                'CurrencyTextBox',
                'currencybox',
                array(
                    'label' => 'CurrencyTextBox',
                    'required'  => true,
                    // 'currency' => 'USD',
                    'invalidMessage' => 'Invalid amount. ' .
                                        'Include dollar sign, commas, ' .
                                        'and cents.',
                    // 'fractional' => true,
                    // 'symbol' => 'USD',
                    // 'type' => 'currency',
                )
            )
            ->addElement(
                'NumberTextBox',
                'numberbox',
                array(
                    'label' => 'NumberTextBox',
                    'required'  => true,
                    'invalidMessage' => 'Invalid elevation.',
                    'constraints' => array(
                        'min' => -20000,
                        'max' => 20000,
                        'places' => 0,
                    )
                )
            )
            ->addElement(
                'ValidationTextBox',
                'validationbox',
                array(
                    'label' => 'ValidationTextBox',
                    'required'  => true,
                    'regExp' => '[\w]+',
                    'invalidMessage' => 'Invalid non-space text.',
                )
            )
            ->addElement(
                'Textarea',
                'textarea',
                array(
                    'label'    => 'Textarea',
                    'required' => true,
                    'style'    => 'width: 200px;',
                )
            );

        $birthday = new \Zend\Dojo\Form\Element\DateTextBox('birthday');
        $birthday->setLabel('Birthday');
        $submit = $form->createElement('submit', 'submit');

        $form->addElements(array($birthday, $submit));

*/


        return array(
            'form' => "",
        );
    }

    public function printAction(){
        $contract_id = $this->getRequest()->getMetadata('contract', null);

        if ($contract_id && $this->getRequest()->getMetadata('save', false)){
            $serviceContract = $this->getLocator()->get('service-contract')->load($contract_id);
            $dataContract = $serviceContract->getData();

            $serviceClient = $this->getLocator()->get('service-client')->load($dataContract['client_id']);
            $dataClient = $serviceClient->getData();

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

        /*/ Set properties
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
        */
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
        //echo $t;

        return array(
            'form' => $t,
            'contract_id'=>$contract_id
        );
    }


}