<?php
/**
 * @author Prima Noor 
 */
   
class ViewModKmsmeeting extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_modkmsmeeting.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsmeeting = GtfwDispt()->load->business('ModKmsmeeting', 'mod.kmsmeeting');
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
		$total = $ObjModKmsmeeting->countModKmsmeeting($filter);
		$data = $ObjModKmsmeeting->getModKmsmeeting($filter);
		
		$url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);
                
      	return compact('data', 'message', 'filter','display');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
   	 $this->ButtonRendering();
     extract($rdata);
   //     echo "<pre>";
   //  print_r($data);
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
                $val['no'] = $no;
                  $this->mrTemplate->clearTemplate('button_delete');
               
                if ($val['uploadby'] ==$_SESSION['username']){
                 $this->mrTemplate->SetAttribute('button_delete','visibility','visible');
                 $this->mrTemplate->SetAttribute('button_update','visibility','visible');
          
            $this->mrTemplate->SetAttribute('data','visibility','visible');
           $this->mrTemplate->AddVar('item', 'FILEPATH', $file_path);
                $this->mrTemplate->addVar('item','FILE', $val['lam_filedata']);
           $this->mrTemplate->addVar('item','FILE2', $val['filedata_enc']);
          
               $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
              $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('mod.kmsmeeting', 'deleteModKmsmeeting', 'do', 'json').'&id='.$val['meeting']);
          
              $this->mrTemplate->addVar('button_detail', 'URL', GtfwDispt()->GetUrl('mod.kmsmeeting', 'detailModKmsmeeting', 'view', 'json').'&id='.$val['meeting']);
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('mod.kmsmeeting', 'updateModKmsmeeting', 'view', 'html').'&id='.$val['meeting']);
           
                $val['url_detail'] = GtfwDispt()->GetUrl('mod.kmsmeeting', 'detailModKmsmeeting', 'view', 'html').'&id='.$val['meeting'];
          
           $this->mrTemplate->addVars('item', $val);
           $this->mrTemplate->parseTemplate('item', 'a');
           $no++;
               
               }else{
               $this->mrTemplate->SetAttribute('data','visibility','visible');
           
               $this->mrTemplate->SetAttribute('button_delete','visibility','hidden');
               $this->mrTemplate->SetAttribute('button_update','visibility','hidden');
            //  $this->mrTemplate->SetAttribute('button_detail','visibility','hidden');
          }
              $val['url_detail'] = GtfwDispt()->GetUrl('mod.kmsmeeting', 'detailModKmsmeeting', 'view', 'html').'&id='.$val['meeting'];                   
              $this->mrTemplate->addVars('item', $val);            
              $this->mrTemplate->clearTemplate('button_update');
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
        
        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('mod.kmsmeeting', 'addModKmsmeeting', 'view', 'html'));
    }
}
?>