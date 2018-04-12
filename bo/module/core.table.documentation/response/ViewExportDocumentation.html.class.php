<?php
/**
 * @author Prima Noor 
 */
   
class ViewExportDocumentation extends HtmlResponse
{
   
   	function ProcessRequest()
   	{	
        $ObjDocumentation = GtfwDispt()->load->business('Documentation', 'core.table.documentation');
        GtfwDispt()->load->helper('date');

        $ObjPHPExcel = GtfwDispt()->load->library('PHPExcel');
        GtfwDispt()->load->helper('excel');
        
        $msg = Messenger::Instance()->Receive(__FILE__);
		$filter = isset($msg[0][0])? $msg[0][0]:NULL;
		Messenger::Instance()->Send('core.table.documentation', 'exportDocumentation', 'view', 'html', array($filter), Messenger::NextRequest);
        // overide paging
        unset($filter['display']);
        $data = $ObjDocumentation->getDocumentation($filter);

        $sheet = $ObjPHPExcel->setActiveSheetIndex(0);

        $cols = array(
            array(
                'name' => 'No',
                'data' => 'no',
                'size' => 5,
                'align' => 'center'),
            array(
                'name' => 'Nama',
                'data' => 'name',
                'size' => 20),
            array(
                'name' => 'Nama Tabel',
                'data' => 'table',
                'size' => 30),
            array(
                'name' => 'Description',
                'data' => 'desc',
                'size' => 50,
                'wrap' => true),
            array(
                'name' => 'Dependency Source',
                'data' => 'dependency_source',
                'size' => 30,
                'wrap' => true),
            array(
                'name' => 'Dependency Target',
                'data' => 'dependency_target',
                'size' => 30,
                'wrap' => true),
            array(
                'name' => 'Menu',
                'data' => 'menu_name',
                'size' => 20,
                'wrap' => true),
            array(
                'name' => 'Module',
                'data' => 'module_name',
                'size' => 20,
                'wrap' => true),
                );

        $sheet->setTitle('Table Docs');
        $last_col_string = getColumnString(count($cols) - 1);
        $sheet->mergeCells('A1:' . $last_col_string . '1')->setCellValue('A1', 'GTFW Table Documentation')->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $first_row = 2;
        $last_row = $first_row;
        // set table header
        $last_col = 0;
        foreach ($cols as $col) {
            $sheet->setCellValueByColumnAndRow($last_col, $last_row, $col['name']);
            if ($col['size'])
                $sheet->getColumnDimension(getColumnString($last_col))->setWidth($col['size']);
            $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $last_col++;
        }

        // set table data
        $no = 1;
        if (isset($data))
            foreach ($data as $rows) {
                $last_row++;
                // pre processing each data
                $rows['no'] = $no;
                $rows['dependency_source'] = str_replace('|', '.', $rows['dependency_source']);
                $rows['dependency_target'] = str_replace('|', '.', $rows['dependency_target']);
                
                $last_col = 0;                
                // parsing data
                foreach ($cols as $col) {
                    $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $sheet->setCellValueByColumnAndRow($last_col, $last_row, $rows[$col['data']]);
                    if ($col['align']) {
                        switch ($col['align']) {
                            case 'center':
                                $align = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
                                break;
                            case 'left':
                                $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                                break;
                            case 'right':
                                $align = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
                                break;
                            case 'justify':
                                $align = PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY;
                                break;
                        }
                        $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setHorizontal($align);
                    }
                    if ($col['wrap']) {
                        $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setWrapText(true);
                    }
                    $last_col++;
                }
                $no++;
            }

        $border = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

        $ObjPHPExcel->getActiveSheet()->getStyle('A' . $first_row . ':' . (getColumnString(count($cols) - 1)) . ($first_row + count($data)))->applyFromArray($border);

        $ObjPHPExcel->SetFileName('GTFW Table Documentation.xls');
        $ObjPHPExcel->Save();

        exit;
   	}
}
?>