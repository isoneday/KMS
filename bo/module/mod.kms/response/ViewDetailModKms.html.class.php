<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKms extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkms.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKms = GtfwDispt()->load->business('ModKms', 'mod.kms');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKms->getDetailModKms($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kms', 'ModKms', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKms';
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