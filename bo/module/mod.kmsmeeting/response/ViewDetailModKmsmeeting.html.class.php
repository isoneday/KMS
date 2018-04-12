<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKmsmeeting extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmsmeeting.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsmeeting = GtfwDispt()->load->business('ModKmsmeeting', 'mod.kmsmeeting'); 
        $id = $_GET['id']->Integer()->Raw();
        $detail = $ObjModKmsmeeting->getDetailModKmsmeeting($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsmeeting', 'ModKmsmeeting', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsmeeting';
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