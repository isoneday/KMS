  <?php
/** 
* @copyright Copyright (c) 2014, PT Gamatechno Indonesia
* @license http://gtfw.gamatechno.com/#license
*/
   
class ViewDetailModKmsdata extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmsdata.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsdata = GtfwDispt()->load->business('ModKmsdata', 'mod.kmsdata');  
        $id = $_GET['id']->Integer()->Raw();        
        $dataFoto = $ObjModKmsdata->GetListFoto($id);
        $detail = $ObjModKmsdata->getDetailModKmsdata($id);
    		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsdata', 'ModKmsdata', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsdata';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);        
      	return compact('dataFoto','detail');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        // echo "<pre>";
         //print_r($dataFoto);die();
        if (!empty($dataFoto)) {
            if ($dataFoto[0]['type']=="jpg"||$dataFoto[0]['type']=="jpeg"||$dataFoto[0]['type']=="JPG"||$dataFoto[0]['type']=="JPEG"||$dataFoto[0]['type']=="png"||$dataFoto[0]['type']=="PNG"||$dataFoto[0]['type']=="txt"){
                $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
                $file_path = Configuration::Instance()->GetValue('application', 'aplikan_filedata');
                $this->mrTemplate->AddVar('foto', 'FILEPATH', $file_path);
                $this->mrTemplate->addVars('foto', $dataFoto[0]);
            } else if($dataFoto[0]['type']=="docx"){
                $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
            }
        }

        if (!empty($detail)) {
            $this->mrTemplate->addVars('content', $detail);
        }
   	}
}
?>