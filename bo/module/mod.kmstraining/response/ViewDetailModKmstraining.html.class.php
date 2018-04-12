<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKmstraining extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmstraining.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmstraining = GtfwDispt()->load->business('ModKmstraining', 'mod.kmstraining');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKmstraining->getDetailModKmstraining($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmstraining', 'ModKmstraining', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmstraining';
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