<?php

/**
 * @author Prima Noor 
 */
class ViewExportKmsProblem extends HtmlResponse {

    // new way, simple, automatic
    function ProcessRequest() {
        $ObjModKmsproblem = GtfwDispt()->load->business('ModKmsproblem', 'mod.kmsproblem');
        $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');
        
        $ObjFormater = GtfwDispt()->load->library('Formater');
        $date_view_format = $ObjSetting->getValue('date_view_format');
        $periode = $ObjFormater->dateFormat(date("Y-m-d"), $date_view_format);
        
		$msg = Messenger::Instance()->Receive(__FILE__);
		$filter_data = isset($msg[0][0])? $msg[0][0]:NULL;		
		$message['content'] = isset($msg[1][1])?$msg[1][1]:NULL;
		$message['style'] = isset($msg[1][2])?$msg[1][2]:NULL;
		
		if (!isset($_GET['display']) || empty($filter_data)) {
		    $page = 1;
		    $start = 0;
		    $display = $ObjSetting->getValue('view_per_page');
		    $filter = compact('page', 'display', 'start');
		} 	elseif ($_GET['display']->Raw() != '') {
		    $page = (int)$_GET['page']->SqlString()->Raw();
		    $display = (int)$_GET['display']->SqlString()->Raw();
		
		    if ($page < 1)
		        $page = 1;
		    if ($display < 1)
		        $display = $ObjSetting->getValue('view_per_page');
		    $start = ($page - 1) * $display;
		
		    $filter = compact('page', 'display', 'start');
		    $filter += $filter_data;
		} 	else {
		    $filter = $filter_data;
		    $page = $filter['page'];
		    $display = $filter['display'];
		    $start = $filter['start'];
		}
		
		Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);
        
		if (!empty($filter['display']))
            unset($filter['display']);
		
		$data = $ObjModKmsproblem->getModKmsproblem($filter);	
	
		// print_r($data);
  //       echo"</pre>";die();
        //if (!empty($data)) {
            $ObjPHPExcel = Dispatcher::Instance()->load->library('PHPExcel');
            
            $filename = '' . GtfwLangText('template') . '_' . GtfwLangText('log_problem') . '_' . date('YmdHis') . '.xlsx';
            $ObjPHPExcel->setFileName($filename);
            $ObjPHPExcel->setWriter('Excel2007'); // optional, Excel5 atau Excel2007 default Excel5
			PHPExcel_Shared_String::setDecimalSeparator('.');
			PHPExcel_Shared_String::setThousandsSeparator(',');

			$ObjPHPExcel->setActiveSheetIndex(0);
			$activeSheet = $ObjPHPExcel->getActiveSheet();
			
			
           $kolom = array('A','B','C','D','E','F','G');
            
			//Configuration -------------------------------------------------------------------------
			$header = array('iduser',
							'problem',
							'person_request',
							'person_solving',
							'PIC',
							'status',							
							'catatan'
						);		
			// --------------------------------------------------------------------------------------
			
			$jml_kolom = count($header);   
			
			//Creating Border -------------------------------------------------------------------
			$styleArray = array(
				   'borders' => array(
						 'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '000000'),
						 ),
						 'inside' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '000000'),
						 ),
				   ),
			);		
			
			//Column Header
			for($i=0;$i<$jml_kolom;$i++){
				$activeSheet->setCellValue("$kolom[$i]1", $header[$i]);
			}
			
			//width colum
			$activeSheet->getColumnDimension("A")->setWidth(5);
			$activeSheet->getColumnDimension("B")->setWidth(45);
			$activeSheet->getColumnDimension("C")->setWidth(25);
			$activeSheet->getColumnDimension("D")->setWidth(25);
			$activeSheet->getColumnDimension("E")->setWidth(25);
			$activeSheet->getColumnDimension("F")->setWidth(25);
			$activeSheet->getColumnDimension("G")->setWidth(25);
			
			//Header Style
			$tmp = $jml_kolom-1;
			$activeSheet->getStyle("A1:$kolom[$tmp]1")->getFont()->setBold(true);
			$activeSheet->getStyle("A1:$kolom[$tmp]1")->getAlignment()->setHorizontal('center');
			$activeSheet->getStyle("A1:$kolom[$tmp]1")->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFF99');
			$activeSheet->getStyle("A1:$kolom[$tmp]1")->applyFromArray($styleArray);
			
			$set_kolom = 2;
			$total_row = count($data);
			//parsing in detail here
			$no=0;
			foreach ($data as $key => $value) {
			    $activeSheet->setCellValue($kolom[0].$set_kolom, $value['id_user_problem']);
				$activeSheet->setCellValue($kolom[1].$set_kolom, $value['problemm']);
				$activeSheet->setCellValue($kolom[2].$set_kolom, $value['person_request']);
				$activeSheet->setCellValue($kolom[3].$set_kolom, $value['person_solving']);
				$activeSheet->setCellValue($kolom[4].$set_kolom, $value['PIC']);
				$activeSheet->setCellValue($kolom[5].$set_kolom, $value['status']);
				$activeSheet->setCellValue($kolom[6].$set_kolom, $value['catatan']);
				
				$set_kolom++;
			}
			
			for($box=1; $box<=$total_row+1; $box++){
				$activeSheet->getStyle($kolom[0].$box.':'.$kolom[5].$box)->applyFromArray($styleArray);				
				$activeSheet->getStyle($kolom[0].$box)->getAlignment()->setHorizontal('center');	
				$activeSheet->getStyle($kolom[2].$box)->getAlignment()->setHorizontal('center');	
				$activeSheet->getStyle($kolom[3].$box)->getAlignment()->setHorizontal('center');	
				$activeSheet->getStyle($kolom[4].$box)->getAlignment()->setHorizontal('center');
			}
			
			
            $ObjPHPExcel->save();
            exit;
        /*} else {
            exit(GtfwLangText('data_not_found'));
        }*/
    }

}

?>