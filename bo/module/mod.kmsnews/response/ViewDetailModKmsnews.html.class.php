<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKmsnews extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmsnews.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsnews = GtfwDispt()->load->business('ModKmsnews', 'mod.kmsnews');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKmsnews->getDetailModKmsnews($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsnews', 'ModKmsnews', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsnews';
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