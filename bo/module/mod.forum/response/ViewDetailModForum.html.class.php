<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModForum extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modforum.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModForum = GtfwDispt()->load->business('ModForum', 'mod.forum');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModForum->getDetailModForum($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.forum', 'ModForum', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModForum';
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