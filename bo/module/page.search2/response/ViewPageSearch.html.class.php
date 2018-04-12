<?php
/**
 * @author Prima Noor 
 */
   
class ViewPageSearch extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_pagesearch.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjPageSearch = GtfwDispt()->load->business('PageSearch', 'page.search');
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

		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsdata', 'ModKmsdata', 'view', 'html').'&display';
        $nav[0]['menu'] = GtfwLangText([]);
        $title = empty($id)?GtfwLangText('searching'):GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
              Messenger::Instance()->SendToComponent('mod.kmsdata', 'comboModKmsdata', 'view', 'html', 'idmasdok', array(
            'dataId' => $data['idmasdok'],
            'elmId' => 'idmasdok',
            'first' => 'select',
            'showAdd' => false,
            'name' => 'idmasdok',
            'style' => '',
            'script' => ''), Messenger::CurrentRequest);    
		
		$post_data = $_POST->AsArray();
		if (isset($post_data))
		//	print_r($post_data);
		$filter['idmasdok'] = $post_data['idmasdok'];
		    foreach ($post_data as $key => $value)
		        $filter[$key] = $value;

		Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);
		$filter_key = $_POST['question'];        
	//$total = $ObjPageSearch->countPageSearch($filter);
		$data = $ObjPageSearch->getPageSearch($filter);
		$url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);
            
      	return compact('data', 'message', 'filter','elmId');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
   	    $this->ButtonRendering();
		extract($rdata);
		// print_r("<pre>");
		// print_r($filter);	
		 //print_r("</pre>");
//		die();
		/* for($i=0; $i<count($data); $i++){
			echo $data[$i]['filename'];
			echo "<br />";
		}
		die(); */
                
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
            $a=$val['filename'];
               $b=$val['lam_filedata'];
			$c=$a==$b;
            foreach ($data as $val) {       
                $val['no'] = $no;
              	$this->mrTemplate->addVar('item', 'keyword', $val['keyword']);
				    $this->mrTemplate->AddVar('item', 'KMSDATA_KEYWORD', $val['kmsdata_keyword']);
        
				    $this->mrTemplate->AddVar('item', 'FILEPATH', $file_path);
				    $this->mrTemplate->AddVar('item', 'FILE_DOWNLOAD', $val['file_download']);
               $this->mrTemplate->addVar('item','FILE', $val['filedata_path']);
               $this->mrTemplate->addVar('item','FILE3', $val['cari']);
             
            //    $this->mrTemplate->addVar('item','FILES', $val['filename']);
            
			//	$this->mrTemplate->addVar('item', 'file', $val['filename']);
				$this->mrTemplate->addVar('item', 'line', $val['line']);
                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
        
        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('page.search', 'addPageSearch', 'view', 'html'));
   	}
}
?>