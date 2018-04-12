<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModListsearching extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modlistsearching.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModListsearching = GtfwDispt()->load->business('ModListsearching', 'mod.listsearching');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModListsearching->getDetailModListsearching($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.listsearching', 'ModListsearching', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModListsearching';
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