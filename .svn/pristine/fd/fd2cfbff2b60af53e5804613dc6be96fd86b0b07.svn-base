<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailLegalInformation extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_legalinformation.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjLegalInformation = GtfwDispt()->load->business('LegalInformation', 'cms.legal.information');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjLegalInformation->getDetailLegalInformation($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('cms.legal.information', 'LegalInformation', 'view', 'html').'&display';
        $nav[0]['menu'] = 'LegalInformation';
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
        $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('cms.legal.information', 'updateLegalInformation', 'view', 'html').'&id='.$detail['id']);
   	}
}
?>