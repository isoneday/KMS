<?php
/**
 * @author Prima Noor 
 */
   
class ViewExcel extends HtmlResponse
{

   	function ProcessRequest()
   	{	
        $ObjUser = GtfwDispt()->load->business('User', 'core.user');
        Dispatcher::Instance()->load->helper('date');
        
        $msg = Messenger::Instance()->Receive(__FILE__);
        
        $filter = array();
        // $filter = isset($msg[count($msg)-1][0]) ? $msg[count($msg)-1][0] : NULL;
        // Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'excelDaily', Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::NextRequest);
        // if (!empty($filter['display'])) unset($filter['display']);

        $data = $ObjUser->getUser($filter);

        if (!empty($data)) {
            #============== PHP EXCEL ============
            Dispatcher::Instance()->load->helper('excel');
            $ObjPHPExcel = Dispatcher::Instance()->load->library('PHPExcel');
            $sheet = $ObjPHPExcel->setActiveSheetIndex(0);
    
            $cols = array(
                // array(
                //     'name' => 'Header Column',   // Teks header table
                //     'data' => 'data_key',        // index key dari data
                //     'size' => 5,                 // size
                //     'align' => 'center'          // horizontal alignment
                //     'wrap' => true,              // wrap if too long
                //     'type' => 'text',            // set type to text, misal untuk menampilkan nomor telp 08637263872
                // ),
                array(
                    'name' => 'No',
                    'data' => 'no',
                    'size' => 5,
                    'align' => 'center'),
                array(
                    'name' => GtfwLangText('username'),
                    'data' => 'name',
                    'size' => 20),
                array(
                    'name' => GtfwLangText('real_name'),
                    'data' => 'real_name',
                    'size' => 20),
                array(
                    'name' => GtfwLangText('email'),
                    'data' => 'email',
                    'size' => 30),
                array(
                    'name' => GtfwLangText('last_logged_in'),
                    'data' => 'last_logged_in',
                    'size' => 20),
                    );
    
            $sheet->setTitle('Data');
            $last_col_string = getColumnString(count($cols) - 1);
            $sheet->mergeCells('A1:' . $last_col_string . '1')->setCellValue('A1', 'Users')->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getFont()->setBold(true);
    
            $first_row = 3;
            $last_row = $first_row;
            // set table header
            $last_col = 0;
            foreach ($cols as $col) {
                $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->setCellValueByColumnAndRow($last_col, $last_row, $col['name']);
                if ($col['size'])
                    $sheet->getColumnDimension(getColumnString($last_col))->setWidth($col['size']);
                $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow($last_col, $last_row)->getFont()->setBold(true);
                $last_col++;
            }
    
            // set table data
            $firt_data_row = $last_row+1;
            $no = 1;
            if (!empty($data))
                foreach ($data as $rows) {
                    $last_row++;
                    // pre processing each data
                    $rows['no'] = $no;
                    if (!empty($rows['last_logged_in']))
                    $rows['last_logged_in'] = IndonesianDate($rows['last_logged_in']).' '.date('H:i', strtotime($rows['last_logged_in']));
                    
                    $last_col = 0;                
                    // parsing data
                    foreach ($cols as $col) {
                        $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                        if (!empty($col['type']) AND $col['type'] == 'string')
                            $sheet->setCellValueExplicitByColumnAndRow($last_col, $last_row, $rows[$col['data']]);
                        else 
                            $sheet->setCellValueByColumnAndRow($last_col, $last_row, $rows[$col['data']]);
                        if (!empty($col['align'])) {
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
                        if (!empty($col['wrap']) AND $col['wrap'] == true) {
                            $sheet->getStyleByColumnAndRow($last_col, $last_row)->getAlignment()->setWrapText(true);
                        }
                        $last_col++;
                    }
                    $no++;
                }
                $last_data_row = $last_row;
    
            $border = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    
            $sheet->getStyle('A' . $first_row . ':' . (getColumnString(count($cols) - 1)) . ($last_data_row))->applyFromArray($border);

            $filename = 'Laporan Data Pengguna.xls';
            $ObjPHPExcel->SetFileName($filename);

            $ObjPHPExcel->SetWriter('Excel5'); // optional, Excel5 atau Excel2007 default Excel5
            
            $ObjPHPExcel->Save(); 
            exit;
        } else {
            exit('Export File Gagal!');
        }

      	return NULL;
   	}
}
?>