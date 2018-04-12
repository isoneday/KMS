<?php
set_time_limit(0);
/**
 * @author Prima Noor 
 */

class ViewExcelImport extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(GTFWConfiguration::GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_excel_import.html');
    }

    function ProcessRequest()
    { 
            
        $data = array();
        if (isset($_FILES['file']['tmp_name'])) {
            $ObjPHPExcel = GtfwDispt()->load->library('PHPExcel');
            
            $inputFileName = ($_FILES['file']['tmp_name']);
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName); 
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);  
            $objPHPExcel = $objReader->load($inputFileName);
             
            foreach($objPHPExcel->getWorksheetIterator() as $worksheet){			
    			foreach ($worksheet->getRowIterator() as $row) {				
    				$cellIterator = $row->getCellIterator();
    				$cellIterator->setIterateOnlyExistingCells(true);
    				foreach ($cellIterator as $cell) {
    					if (!is_null($cell)) {		
    						$row_data[] = $cell->getFormattedValue();
    					}
    				}
                    $data[] = $row_data;                   
                    unset($row_data);
                }
            }
//Kode di bawah ini untuk konversi ddc ke golongan
            if (!empty($data)) {
                $ObjGol = Dispatcher::Instance()->load->business('Gol');
                                $success = 0;
                $failed = 0;
                $fail_msg = '';
                $i = 0;
                
                foreach ($data as $val) {
                    if ($ObjGol->isKategori($val[0])) continue;
                    //echo '<pre>'; print_r($ObjGol->GetLastError()); echo '</pre>';
                    $param = array(
                        substr($val[0],0,1).'00',
                        $val[0],
                        $val[1]
                    );
                    
                    $result = $ObjGol->addGolongan($param);
                    //echo '<pre>'; print_r($ObjGol->GetLastError()); echo '</pre>';
                    $i++;
                    
                    //if ($i > 20) exit;
                }
                //exit;
            }

//Kode di bawah ini untuk konversi religion book ION's
/*    
        
            if (!empty($data)) {
                $ObjBuku = Dispatcher::Instance()->load->business('Book');
                
                $success = 0;
                $failed = 0;
                $fail_msg = '';
                $i = 0;
                foreach ($data as $val) {
                    if(intval($val[1]) !== 0 AND intval($val[1]) !== 0) {
                        //$gol_id = $ObjBuku->getGolonganId(trim($val[2]));
                        //echo '<pre>'; print_r($ObjBuku->GetLastError()); echo '</pre>';
                        //$sec_id = $ObjBuku->getSeksiId(trim($val[4]));
                        //echo '<pre>'; print_r($ObjBuku->GetLastError()); echo '</pre>';
                        //$ting_id = $ObjBuku->getTingkatId(trim($val[8]));
                        //echo '<pre>'; print_r($ObjBuku->GetLastError()); echo '</pre>';
                        //echo '<pre>'; print_r($val); echo '</pre>';
                        $penerbit_id = $ObjBuku->getPenerbitId(trim($val[17]));
                        //echo '<pre>'; print_r($ObjBuku->GetLastError()); echo '</pre>';
                        
                        $param = array(
                            $penerbit_id,
                            addslashes($val[13])
                        );
                        $result = $ObjBuku->updateBook($param);
                        //echo '<pre>'; print_r($ObjBuku->GetLastError()); echo '</pre>';
                        if ($result === true)
                            $success++;
                        else {
                            $failed++;
                            $fail_msg .= "<pre>".$ObjBuku->GetLastError()."</pre>";
                        }
                        $i++;         
                    }
//                    if ($i > 5)
//                        exit('stopped');
                }
                exit;
            }
*/

        }

        return compact('data', '$success', 'failed','fail_msg');
    }

    function ParseTemplate($rdata = null)
    {
        extract($rdata);
        
        if (!empty($success) || !empty($failed)) {
            $msg = $success.' data success, '.$failed.' data failed';
            $this->mrTemplate->addVar('message', 'CONTENT', $msg);
            $this->mrTemplate->addVar('message', 'STYLE', 'notebox-info');
        }
        
        if (!empty($fail_msg)) {
            $this->mrTemplate->addVar('fail_message', 'CONTENT', $fail_msg);
        }
        
        if (!empty($data)) {
            $this->mrTemplate->addVar('mode', 'MODE', 'OUTPUT');
//            foreach ($data as $row) {
//                $row_data = "";
//                if (!empty($row))
//                foreach ($row as $cell) {
//                    $row_data .= "<td>$cell</td>";
//                }
//                $this->mrTemplate->addVar('row_item', 'ROW_DATA', $row_data);
//                $this->mrTemplate->parseTemplate('row_item', 'a');
//            }
        } else {
            $this->mrTemplate->addVar('mode', 'MODE', 'INPUT');
            $this->mrTemplate->addVar('mode', 'URL', Dispatcher::Instance()->GetCurrentUrl());
        }
    }
}

?>