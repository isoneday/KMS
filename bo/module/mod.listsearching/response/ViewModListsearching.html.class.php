<?php
/**
 * @author Prima Noor 
 */
   
class ViewModListsearching extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_modlistsearching.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModListsearching = GtfwDispt()->load->business('ModListsearching', 'mod.listsearching');
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
       $title = empty($id)?GtfwLangText('documentation'):GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
              Messenger::Instance()->SendToComponent('mod.kmsdata', 'comboModKmsdata', 'view', 'html', 'idmasdok', array(
            'dataId' => $data['idmasdok'],
            'elmId' => 'idmasdok',
            'first' => 'select',
            'showAdd' => false,
            'name' => 'idmasdok',
            'style' => '',
            'script' => 'OnChange=setForm()'), Messenger::CurrentRequest);       
       $post_data = $_POST->AsArray();
    if (isset($post_data))
   //   print_r($post_data);
    $filter['idmasdok'] = $post_data['idmasdok'];
   foreach ($post_data as $key => $value)
            $filter[$key] = $value;
    Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);
    $filter_key = $_POST['question'];        
    //$total = $ObjModListsearching->countModListsearching($filter);
    $data = $ObjModListsearching->getModListsearching($filter);
    $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
    Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
    Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);
        return compact('data', 'message', 'filter','elmId','display');


   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
   	    $this->ButtonRendering();
		extract($rdata);
    //echo"<pre>";
 		//print_r($data);
    if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }     
        
      $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl().'&display');
    if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }
          
        if (!empty($data) AND count($data)>0) {
            	 $file_path = Configuration::Instance()->GetValue('application', 'aplikan_filecari');
       
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = $filter['start'] + 1;
            foreach ($data as $val) {       
                $val['no'] = $no;
                $val['url_detail'] = GtfwDispt()->GetUrl('mod.listsearching', 'detailModListsearching', 'view', 'html').'&id='.$val['id'];
                				    $this->mrTemplate->AddVar('item', 'FILEPATH', $file_path);
				    $this->mrTemplate->AddVar('item', 'FILE_DOWNLOAD', $val['lam_filedata']);
 //$this->mrTemplate->addVar('item','FILE', $val['filedata_path']);
               
                $this->mrTemplate->clearTemplate('button_update');
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('mod.listsearching', 'updateModListsearching', 'view', 'html').'&id='.$val['id']);
                
                $this->mrTemplate->clearTemplate('button_delete');
                $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
                $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('mod.listsearching', 'deleteModListsearching', 'do', 'json').'&id='.$val['id']);
                
                if($val['idmasdok'] == 1){
                   $this->mrTemplate->addVar('content', 'STYLE_JUDUL','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_JUDUL_VALUE','display:none;'); 

                   // $this->mrTemplate->addVar('content', 'STYLE_JENIS','display:none;'); 
                   // $this->mrTemplate->addVar('item', 'STYLE_JENIS_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_NAME_PRODUCT','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_PRODUCT_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_TYPE_PRODUCT','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_TYPE_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_DIVISI','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_DIVISI_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_UPLOAD','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_UPLOAD_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_TANGGAL','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_TANGGAL_VALUE','display:none;');

                    $this->mrTemplate->addVar('content', 'STYLE_ATC','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE','display:none;');
                }

                 if($val['idmasdok'] == 2){
                   //$this->mrTemplate->addVar('content', 'STYLE_JUDUL','display:none;'); 
                   //$this->mrTemplate->addVar('item', 'STYLE_JUDUL_VALUE','display:none;'); 

                  $this->mrTemplate->addVar('content', 'STYLE_JENIS','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_JENIS_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_NAME_PRODUCT','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_PRODUCT_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_TYPE_PRODUCT','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_TYPE_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_DIVISI','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_DIVISI_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_UPLOAD','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_UPLOAD_VALUE','display:none;'); 

                  $this->mrTemplate->addVar('content', 'STYLE_TANGGAL','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_TANGGAL_VALUE','display:none;');

                    $this->mrTemplate->addVar('content', 'STYLE_ATC','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE','display:none;');
                }

                 if($val['idmasdok'] == 3){
                   $this->mrTemplate->addVar('content', 'STYLE_JUDUL','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_JUDUL_VALUE','display:none;'); 

                  $this->mrTemplate->addVar('content', 'STYLE_JENIS','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_JENIS_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_NAME_PRODUCT','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_PRODUCT_VALUE','display:none;'); 

                   // $this->mrTemplate->addVar('content', 'STYLE_TYPE_PRODUCT','display:none;'); 
                   // $this->mrTemplate->addVar('item', 'STYLE_TYPE_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_DIVISI','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_DIVISI_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_UPLOAD','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_UPLOAD_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_TANGGAL','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_TANGGAL_VALUE','display:none;');

                    $this->mrTemplate->addVar('content', 'STYLE_ATC','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE','display:none;');
                }
                 
                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('content', 'STYLE_JUDUL','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_JUDUL_VALUE','display:none;'); 

                  $this->mrTemplate->addVar('content', 'STYLE_JENIS','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_JENIS_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_NAME_PRODUCT','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_PRODUCT_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_TYPE_PRODUCT','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_TYPE_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_DIVISI','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_DIVISI_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_UPLOAD','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_UPLOAD_VALUE','display:none;'); 

                   $this->mrTemplate->addVar('content', 'STYLE_TANGGAL','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_TANGGAL_VALUE','display:none;');

                    $this->mrTemplate->addVar('content', 'STYLE_ATC','display:none;'); 
                   $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE','display:none;');

//            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
        
        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('mod.listsearching', 'addModListsearching', 'view', 'html'));
   	}
}
?>