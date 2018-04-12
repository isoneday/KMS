<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKmsmanagereward extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmsmanagereward.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsmanagereward = GtfwDispt()->load->business('ModKmsmanagereward', 'mod.kmsmanagereward');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKmsmanagereward->getDetailModKmsmanagereward($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsmanagereward', 'ModKmsmanagereward', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsmanagereward';
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