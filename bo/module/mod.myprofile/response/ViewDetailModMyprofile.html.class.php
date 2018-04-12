<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModMyprofile extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modmyprofile.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModMyprofile = GtfwDispt()->load->business('ModMyprofile', 'mod.myprofile');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModMyprofile->getDetailModMyprofile($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.myprofile', 'ModMyprofile', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModMyprofile';
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