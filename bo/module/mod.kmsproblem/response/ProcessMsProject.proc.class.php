<?php
/**
 * @author Prima Noor
 */
 
class ProcessMsProject
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjMsProject = GtfwDispt()->load->business('MsProject');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
       
        $Val->set_rules('name', GtfwLangText('name'), 'required');
        $Val->set_rules('code', GtfwLangText('code'), 'required');
        //$Val->set_rules('hyperion', GtfwLangText('hyperion'), 'required');
        
		$hyperion = str_replace("/","_",$post['code']);
		
        $result = $Val->run();

        if ($result) {
			$post['company'] = (int)$post['company'];
			$post['type'] = (int)$post['type'];
            if (!$post['id']) {
                $this->ObjMsProject->StartTrans();
                $params = array(
                    $post['name'],
                    $post['code'],
                    $hyperion,
                    $post['company'],
                    $post['type'],
                    $this->user
                );
                $result = $result && $this->ObjMsProject->insertMsProject($params);
                $this->ObjMsProject->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjMsProject->StartTrans();
                $params = array(
                    $post['name'],
                    $post['code'],
                    $hyperion,
                    $post['company'],
                    $post['type'],
					//$this->user,
                    $post['id']
                );
                $result = $result && $this->ObjMsProject->updateMsProject($params);
                $this->ObjMsProject->EndTrans($result);   
                if ($result) {
                    $msg = GtfwLangText('msg_update_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_update_fail');
                    $css = $this->cssFail;
                }             
            }
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }     
        if ($result) {
            Messenger::Instance()->Send('ms.project', 'MsProject', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('ms.project', 'msproject', 'view', 'html');
        } else {
            Messenger::Instance()->Send('ms.project', 'inputMsProject', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('ms.project', (empty($post['id'])?'add':'update').'MsProject', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjMsProject->deleteMsProject($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('ms.project', 'MsProject', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
	
	function import(){	
		$post = $_POST->AsArray();

		if (!empty($_FILES['import_file']['tmp_name'])) {

			$PHPExcel = GtfwDispt()->load->library('PHPExcel');
            $fileName = $_FILES['import_file']['name'];
            $inputFileName = ($_FILES['import_file']['tmp_name']);
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $ObjReader = PHPExcel_IOFactory::createReader($inputFileType);
            $ObjWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
            $ObjPHPExcel = $ObjReader->load($inputFileName);
            $ObjWorksheet = $ObjPHPExcel->setActiveSheetIndex(0);

            $data = array();

            foreach ($ObjWorksheet->getRowIterator() as $row) {
                $row_data = array();
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
					if (!is_null($cell)) {
						if(strstr($cell,'=')==true)
						{
							$row_data[] = trim($cell->getOldCalculatedValue());
						} else {
							$row_data[] = trim($cell->getCalculatedValue());
						}
                    }  
                }				
                $data[] = $row_data;
            }
			
			if ($data){
                unset($data[0]);
			}
						
			if (!empty($data)) {
				$this->ObjMsProject->StartTrans();
				$this->ObjMsProject->replaceProject();
				$notShow = array();
				foreach ($data as $key => $val) {
					 $company = $this->ObjMsProject->getCompanyId($val[5]);
					 
					 if(empty($company)){
							$notShow[] = $val[5];
					 } 
					 
					 if($val[4] == 'Project'){
						 $type = 1;
					 } else {
						 $type = 0;
					 }
					 
					 $params = array(
						mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($val[1],ENT_QUOTES)))), 
						$val[2],
						$val[3],
						$company,
						$type
					);
					
					$result = $this->ObjMsProject->insertMsProject($params);
				}				
				
				$this->ObjMsProject->EndTrans($result);
			}
			
			//var_dump($result);
			//die;
			
			if ($result) {
				$msg = GtfwLangText('msg_add_success');
				$css = $this->cssDone;
			} else {
				$msg = GtfwLangText('msg_add_fail');				
				$css = $this->cssFail;
			}
			
			if(!empty($notShow)){
				$msg .= '<hr><b>[Company] These company doesn\'t exists, you can set them at \'Master Company\' : </b><br> &nbsp;&nbsp;&nbsp; - ' . implode('<br> &nbsp;&nbsp;&nbsp; - ', $notShow);
			}
			
			Messenger::Instance()->Send('ms.project', 'importMsProject', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
		}
		else {
			$msg = "Silahkan pilih file";
            $css = $this->cssFail;
            Messenger::Instance()->Send('ms.project', 'importMsProject', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
		}
	}
}

?>