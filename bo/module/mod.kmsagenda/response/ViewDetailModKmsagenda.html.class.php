<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKmsagenda extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmsagenda.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsagenda = GtfwDispt()->load->business('ModKmsagenda', 'mod.kmsagenda');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKmsagenda->getDetailModKmsagenda($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsagenda', 'ModKmsagenda', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsagenda';
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