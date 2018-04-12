<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailCmsFaq extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_cmsfaq.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjCmsFaq = GtfwDispt()->load->business('CmsFaq', 'cms.faq');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjCmsFaq->getDetailCmsFaq($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('cms.faq', 'CmsFaq', 'view', 'html').'&display';
        $nav[0]['menu'] = 'CmsFaq';
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