<?php
/**
 * @author Prima Noor 
 */
   
class ViewModKmsmanagement extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_modkmsmanagement.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsmanagement = GtfwDispt()->load->business('ModKmsmanagement', 'mod.kmsmanagement');
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
		        
		$total = $ObjModKmsmanagement->countModKmsmanagement($filter);
		$data = $ObjModKmsmanagement->getModKmsmanagement($filter);
		
		$url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);
                
      	return compact('data', 'message', 'filter');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
   	    $this->ButtonRendering();
		extract($rdata);
                
		if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }     
        
        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl().'&display');
		if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }
        
        if (!empty($data) AND count($data)>0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = $filter['start'] + 1;
           
            foreach ($data as $val) {       
           
                $val['no'] = $no;
                $val['url_detail'] = GtfwDispt()->GetUrl('mod.kmsmanagement', 'detailModKmsmanagement', 'view', 'html').'&id='.$val['id'];
                
                $this->mrTemplate->clearTemplate('button_update');
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('mod.kmsmanagement', 'updateModKmsmanagement', 'view', 'html').'&id='.$val['id']);
                
                $this->mrTemplate->clearTemplate('button_delete');
                $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
                $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('mod.kmsmanagement', 'deleteModKmsmanagement', 'do', 'json').'&id='.$val['id']);
                
                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
             
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
         if($_SESSION['username']=='admin'){
              
              $this->mrTemplate->SetAttribute('button_add','visibility','visible');
               $this->mrTemplate->SetAttribute('button_add2','visibility','visible');
               $this->mrTemplate->SetAttribute('button_add3','visibility','visible');
               $this->mrTemplate->SetAttribute('button_add4','visibility','visible');
            
        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('mod.kmsmanagement', 'addModKmsmanagement', 'view', 'html'));
 		$this->mrTemplate->addVar('button_add2', 'URL', GtfwDispt()->GetUrl('mod.kmsmanagement', 'addModKmsmanagement', 'view', 'html'));
 		$this->mrTemplate->addVar('button_add3', 'URL', GtfwDispt()->GetUrl('mod.kmsmanagement', 'addModKmsmanagement', 'view', 'html'));
   	  $this->mrTemplate->addVar('button_add4', 'URL', GtfwDispt()->GetUrl('mod.kmsmanagement', 'addModKmsmanagement', 'view', 'html'));
   	  
   	}  
else{
	          
	           $this->mrTemplate->SetAttribute('button_add2','visibility','visible');
               $this->mrTemplate->SetAttribute('button_add3','visibility','visible');
    
	$this->mrTemplate->addVar('button_add2', 'URL', GtfwDispt()->GetUrl('mod.kmsmanagement', 'addModKmsmanagement', 'view', 'html'));
 		$this->mrTemplate->addVar('button_add3', 'URL', GtfwDispt()->GetUrl('mod.kmsmanagement', 'addModKmsmanagement', 'view', 'html'));
   	
           }

   		}
}
?>