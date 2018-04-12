<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKmsmanagement extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmsmanagement.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsmanagement = GtfwDispt()->load->business('ModKmsmanagement', 'mod.kmsmanagement');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKmsmanagement->getDetailModKmsmanagement($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsmanagement', 'ModKmsmanagement', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsmanagement';
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