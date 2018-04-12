<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKmsreward extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmsreward.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsreward = GtfwDispt()->load->business('ModKmsreward', 'mod.kmsreward');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKmsreward->getDetailModKmsreward($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsreward', 'ModKmsreward', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsreward';
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