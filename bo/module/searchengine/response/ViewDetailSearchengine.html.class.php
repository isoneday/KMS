<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailSearchengine extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_searchengine.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjSearchengine = GtfwDispt()->load->business('Searchengine', 'searchengine');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjSearchengine->getDetailSearchengine($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('searchengine', 'Searchengine', 'view', 'html').'&display';
        $nav[0]['menu'] = 'Searchengine';
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