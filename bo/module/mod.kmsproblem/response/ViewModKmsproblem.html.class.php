<?php
/**
 * @author Prima Noor 
 */
   
class ViewModKmsproblem extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_modkmsproblem.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsproblem = GtfwDispt()->load->business('ModKmsproblem', 'mod.kmsproblem');
   	    $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');
        
        $msg = Messenger::Instance()->Receive(__FILE__);
		$filter_data = isset($msg[0][0])? $msg[0][0]:NULL;		
		$message['content'] = isset($msg[1][1])?$msg[1][1]:NULL;
		$message['style'] = isset($msg[1][2])?$msg[1][2]:NULL;
		
		if (!isset($_GET['display']) || empty($filter_data)) {
		    $page = 1;
		    $start = 0;
		    $display = $ObjSetting->getValue('view_per_page');
		    $filter = compact('page', 'display', 'start');
		} elseif ($_GET['display']->Raw() != '') {
		    $page = (int)$_GET['page']->SqlString()->Raw();
		    $display = (int)$_GET['display']->SqlString()->Raw();
		
		    if ($page < 1)
		        $page = 1;
		    if ($display < 1)
		        $display = $ObjSetting->getValue('view_per_page');
		    $start = ($page - 1) * $display;
		
		    $filter = compact('page', 'display', 'start');
		    $filter += $filter_data;
		} else {
		    $filter = $filter_data;
		    $page = $filter['page'];
		    $display = $filter['display'];
		    $start = $filter['start'];
		}
		
		$post_data = $_POST->AsArray();
		if (isset($post_data))
		    foreach ($post_data as $key => $value)
		        $filter[$key] = $value;
		Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);
		       
		         $id = $_GET['id']->sqlString()->Raw();
      
		$total = $ObjModKmsproblem->countModKmsproblem($filter);
		$data = $ObjModKmsproblem->getModKmsproblem($filter);
		$dataFoto = $ObjModKmsproblem->GetListFoto($id);
		$dataFoto2 = $ObjModKmsproblem->GetListFoto2($id);
    $dataFoto3 = $ObjModKmsproblem->GetListFoto3($id);
     
		$url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);
                
      	return compact('dataFoto3','dataFoto2','dataFoto','data', 'message', 'filter');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
   	    $this->ButtonRendering();
		extract($rdata);
	//	     echo "<pre>";
      //print_r($data);
     //   print_r($filter);
     // //   die();
    
                
		if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }     
        
        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl().'&display');
		if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }
        
        if (!empty($data) AND count($data)>0) {
             $file_path = Configuration::Instance()->GetValue('application', 'aplikan_filedata');
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = $filter['start'] + 1;
            foreach ($data as $val) {    
              $val['lastuploadby']=$val['uploadby2'];
           
                $val['no'] = $no;
                $val['url_detail'] = GtfwDispt()->GetUrl('mod.kmsproblem', 'detailModKmsproblem', 'view', 'html').'&id='.$val['id_problem'];
                
                $this->mrTemplate->clearTemplate('button_update');
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('mod.kmsproblem', 'updateModKmsproblem', 'view', 'html').'&id='.$val['id_problem']);
                
                $this->mrTemplate->clearTemplate('button_delete');
                     $this->mrTemplate->AddVar('item', 'FILEPATH', $file_path);
                $this->mrTemplate->addVar('item','FILE', $val['lam_filedata']);
          
          
                $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
                $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('mod.kmsproblem', 'deleteModKmsproblem', 'do', 'json').'&id='.$val['id_problem']);
          
                $this->mrTemplate->AddVar('item', 'FILEPATH2', $file_path);
                $this->mrTemplate->addVar('item','FILE2', $val['lam_filedata2']);      
                $this->mrTemplate->AddVar('item', 'FILEPATH3', $file_path);
                $this->mrTemplate->addVar('item','FILE3', $val['lam_filedata3']);      
               if($val['idstatus'] == 1){
                   // $this->mrTemplate->addVar('content', 'STYLE_JENIS','display:none;'); 
                   // $this->mrTemplate->addVar('item', 'STYLE_JENIS_VALUE','display:none;'); 

                   // $this->mrTemplate->addVar('content', 'STYLE_JUDUL','display:none;'); 
                   // $this->mrTemplate->addVar('item', 'STYLE_JUDUL_VALUE','display:none;'); 
        $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE');
          $this->mrTemplate->addVar('item', 'STYLE_UPLOAD_VALUE','display:none;'); 
            
                   // $this->mrTemplate->addVar('content', 'STYLE_UPLOAD','display:none;'); 
                }

                 if($val['idstatus'] == 2){
                   $this->mrTemplate->addVar('content', 'STYLE_TYPE_PRODUCT','display:none;'); 
//                   $this->mrTemplate->addVar('item', 'STYLE_PRODUCT_VALUE','display:none;'); 
          $this->mrTemplate->addVar('item', 'STYLE_UPLOAD_VALUE'); 
        $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE','display:none;');
 $this->mrTemplate->addVar('item', 'STYLE_JENISS_VALUE','display:none;'); 
          
                   //  $this->mrTemplate->addVar('content', 'STYLE_ATC','display:none;'); 
                   // $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE','display:none;');
                }

                
                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
        
        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('mod.kmsproblem', 'addModKmsproblem', 'view', 'html'));
        $this->mrTemplate->addVar('content','URL_EXCEL', GtfwDispt()->GetUrl('mod.kmsproblem', 'exportKmsproblem', 'view', 'html'));
   	}
}
?>