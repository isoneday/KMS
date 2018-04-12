<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailLanguage extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_language.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjLanguage = GtfwDispt()->load->business('Language', 'core.language');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjLanguage->getDetailLanguage($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('core.language', 'language', 'view', 'html').'&display';
        $nav[0]['menu'] = 'Language';
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