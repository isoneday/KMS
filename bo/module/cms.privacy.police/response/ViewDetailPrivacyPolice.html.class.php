<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailPrivacyPolice extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_privacypolice.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjPrivacyPolice = GtfwDispt()->load->business('PrivacyPolice', 'cms.privacy.police');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjPrivacyPolice->getDetailPrivacyPolice($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('cms.privacy.police', 'PrivacyPolice', 'view', 'html').'&display';
        $nav[0]['menu'] = 'PrivacyPolice';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
        
      	return compact('detail');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
    // echo "<pre>";var_dump($rdata);echo "</pre>";
        
        if (!empty($detail)) {
            $this->mrTemplate->addVars('content', $detail);
        }
        $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('cms.privacy.police', 'updatePrivacyPolice', 'view', 'html').'&id='.$detail['id']);
   	}
}
?>