<?php
/** 
* @copyright Copyright (c) 2014, PT Gamatechno Indonesia
* @license http://gtfw.gamatechno.com/#license
*/
   
class ViewModKmsdata extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
        $this->SetTemplateFile('view_modkmsdata.html');
    }
   
    function ProcessRequest()
    { 
        $ObjModKmsdata = GtfwDispt()->load->business('ModKmsdata', 'mod.kmsdata');
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
   $nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsmanagement', 'ModKmsmanagement', 'view', 'html').'&display';
        $nav[0]['menu'] = 'management';
     $title = empty($id)?GtfwLangText('documentation'):GtfwLangText('edit');
          Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
       
    $post_data = $_POST->AsArray();
    if (isset($post_data))
        foreach ($post_data as $key => $value)
            $filter[$key] = $value;
    Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);
    
                  $id = $_GET['id']->sqlString()->Raw();
 //  if($val['user_user_name']=!'admin'){
 //   $filter['username'] = $_SESSION['username']; 
 // } 
 //  else{
 //    echo'sukses';
 //  }
  
    $total = $ObjModKmsdata->countModKmsdata($filter);
    
    $data = $ObjModKmsdata->getModKmsdata($filter);
     $dataFoto = $ObjModKmsdata->GetListFoto($id);
      
    $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
    Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
    Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);
              
        return compact('dataFoto','data', 'message', 'filter','display');
    
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
            //echo "<pre>";
           
//            print_r($data);
          //  echo "</pre>";
            foreach ($data as $val) {       
            $val['no'] = $no;
            
                    $this->mrTemplate->clearTemplate('button_delete');
               
               if ($val['uploadby'] ==$_SESSION['username']){
                 $val['no'] = $no;
                 $this->mrTemplate->SetAttribute('button_delete','visibility','visible');
                 $this->mrTemplate->SetAttribute('button_update','visibility','visible');
               $this->mrTemplate->SetAttribute('button_detail','visibility','visible');
           
            $this->mrTemplate->SetAttribute('data','visibility','visible');
           
        //     $this->mrTemplate->parseTemplate('item', 'a');
               $this->mrTemplate->AddVar('item', 'FILEPATH', $file_path);
                $this->mrTemplate->addVar('item','FILE', $val['lam_filedata']);
           $this->mrTemplate->addVar('item','FILE2', $val['filedata_enc']);
          
          //     $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
          
              $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('mod.kmsdata', 'deleteModKmsdata', 'do', 'json').'&id='.$val['data']);
          
              $this->mrTemplate->addVar('button_detail', 'URL_DETAIL', GtfwDispt()->GetUrl('mod.kmsdata', 'detailModKmsdata', 'view', 'html').'&id='.$val['data']);
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('mod.kmsdata', 'updateModKmsdata', 'view', 'html').'&id='.$val['data']);
           
//                $val['url_detail'] = GtfwDispt()->GetUrl('mod.kmsdata', 'detailModKmsdata', 'view', 'html').'&id='.$val['data'];
           $this->mrTemplate->addVars('item', $val);
           $this->mrTemplate->parseTemplate('item', 'a');
           $no++;
          
               
               }else{
                if($_SESSION['username']=='admin'){
                       $this->mrTemplate->SetAttribute('button_delete','visibility','visible');
                 $this->mrTemplate->SetAttribute('button_update','visibility','visible');
               $this->mrTemplate->SetAttribute('button_detail','visibility','visible');
           
            $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('mod.kmsdata', 'updateModKmsdata', 'view', 'html').'&id='.$val['data']);
              $this->mrTemplate->addVar('button_detail', 'URL_DETAIL', GtfwDispt()->GetUrl('mod.kmsdata', 'detailModKmsdata', 'view', 'html').'&id='.$val['data']);
           
            //    $val['url_detail'] = GtfwDispt()->GetUrl('mod.kmsdata', 'detailModKmsdata', 'view', 'html').'&id='.$val['data'];
           $this->mrTemplate->AddVar('item', 'FILEPATH', $file_path);
                $this->mrTemplate->addVar('item','FILE', $val['lam_filedata']);
           $this->mrTemplate->addVar('item','FILE2', $val['filedata_enc']);
          
           $this->mrTemplate->addVars('item', $val);
           $this->mrTemplate->parseTemplate('item', 'a');
           $no++;
          
               $this->mrTemplate->SetAttribute('data','visibility','visible');
  //    $this->mrTemplate->SetAttribute('button_image','visibility','hidden');
           
               $this->mrTemplate->SetAttribute('button_delete','visibility','hidden');
               $this->mrTemplate->SetAttribute('button_update','visibility','hidden');
              $this->mrTemplate->SetAttribute('button_detail','visibility','hidden');}
 

              else {
//      $this->mrTemplate->SetAttribute('button_image','visibility','hidden');
        
              }
          }
           //   $val['url_detail'] = GtfwDispt()->GetUrl('mod.kmsdata', 'detailModKmsdata', 'view', 'html').'&id='.$val['data'];                   
             // $this->mrTemplate->addVars('item', $val);            
            //  $this->mrTemplate->clearTemplate('button_update');
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
        
        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('mod.kmsdata', 'addModKmsdata', 'view', 'html'));
    }
}
?>