<?php
/** 
* @copyright Copyright (c) 2014, PT Gamatechno Indonesia
* @license http://gtfw.gamatechno.com/#license
*/
   
class ViewInputModKmsdata extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_input_modkmsdata.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsdata = GtfwDispt()->load->business('ModKmsdata', 'mod.kmsdata');
        
        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();
        $dataFoto = $ObjModKmsdata->GetListFoto($id);
         $id = $_GET['id']->Integer()->Raw();        
       
        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0])?$msg[0][0]:NULL;
		$message['content'] = isset($msg[0][1])?$msg[0][1]:NULL;
		$message['style'] = isset($msg[0][2])?$msg[0][2]:NULL;
        
        if (!empty($post)) {
            $input = $post;

        } elseif(!empty($id)) {
            $input = $ObjModKmsdata->getDetailModKmsdata($id);

        }
        		
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsdata', 'ModKmsdata', 'view', 'html').'&display';
        $nav[0]['menu'] = GtfwLangText('modkmsdata');
        $title = empty($id)?GtfwLangText('add'):GtfwLangText('edit');
        //unruk idmasok  
        //  if (!empty($post)) {
        //     $input = $post;
        // } elseif (!empty($id)) {
        //     $input = $ObjUser->getDetailModKmsdata($id);
        //     if (!empty($input)) {
        //         $input['group'] = explode(',', $input['group']);
        //     }
        // }
      
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
              Messenger::Instance()->SendToComponent('mod.kmsdata', 'comboModKmsdata', 'view', 'html', 'idmasdok', array(
            'dataId' => $data['idmasdok'],
            'elmId' => 'idmasdok',
            'first' => 'select',
            'showAdd' => false,
            'name' => 'idmasdok',
            'style' => '',
            'script' => 'OnChange=setForm()'), Messenger::CurrentRequest);       

      	return compact('input', 'id', 'message', 'elmId');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
     
       //     echo "<pre>";
      // print_r($data);
     //   print_r($filter);
       // die();
    
                           
		if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
         
        }
        //untuk masdok
        // if (!empty($listGroup)) {
        //     $title = GtfwLangText('detail');
        //     $allowDetail = Security::Authorization()->IsAllowedToAccess('mod.core.mastertypedokumentasi', 'detailCoreMastertypedokumentasi', 'view', 'html');
        //     foreach ($listGroup as $value) {
        //         $dataGroup = array();
        //         $dataGroup['name'] = $value['name'];
        //         $dataGroup['id'] = $value['id'];
        //         if ($allowDetail) {
        //             $dataGroup['title'] = $title;
        //             $dataGroup['url'] = GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'detailCoreMastertypedokumentasi', 'view', 'html') . '&id=' . $value['id'];
        //         }
        //         if (!empty($input['group']) AND in_array($value['id'], $input['group'])) {
        //             $dataGroup['checked'] = 'checked="checked"';
        //         } else {
        //             $dataGroup['checked'] = '';
        //         }
        //         $this->mrTemplate->addVars('group', $dataGroup);
        //         $this->mrTemplate->parseTemplate('group', 'a');
        //     }
        // }





  //           if (!empty($dataFoto)) {
  //           if ($dataFoto[0]['type']=="jpg"||$dataFoto[0]['type']=="jpeg"||$dataFoto[0]['type']=="JPG"||$dataFoto[0]['type']=="JPEG"||$dataFoto[0]['type']=="PNG"||$dataFoto[0]['type']=="png"||$dataFoto[0]['type']=="txt"){
  //               $file_path = Configuration::Instance()->GetValue('application', 'aplikan_filedata');
  //               $this->mrTemplate->AddVar('foto', 'FILEPATH', $file_path);
            
  //               $this->mrTemplate->addVars('foto', $dataFoto[0]);
  //     $path_to_check2 = "C:/xampp/htdocs/gtfw36cop/files/applicant/registulang/ratu.txt";
  //             $cmd = ($path_to_check2);
  //             exec($cmd);    
  //             } else if($dataFoto[0]['type']=="docx"||$dataFoto[0]['type']=="doc"||$dataFoto[0]['type']=="pdf"){
  //             $path_to_check2 = "C:/xampp/htdocs/gtfw36cop/files/applicant/registulang/ratu.txt";
  //             $cmd = ($path_to_check2);
  //             exec($cmd);    

  //           }
  //       }

        
        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
            $this->mrTemplate->addVar('content','ID', $id);

        }
        
        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('mod.kmsdata', 'ModKmsdata', 'view', 'html').'&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('mod.kmsdata', (empty($id)?'add':'update').'ModKmsdata', 'do', 'json') . '&elmId=' . $elmId);
   	}
}
?>