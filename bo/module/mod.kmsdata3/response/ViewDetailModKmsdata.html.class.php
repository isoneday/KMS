<?php
/**
 * @author Prima Noor 
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
        
        $detail = $ObjModKmsdata->getDetailModKmsdata($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsdata', 'ModKmsdata', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsdata';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
        
      	return compact('detail');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($detail)) {
            $this->mrTemplate->addVars('content', $detail);
        }
   	}
}
?>