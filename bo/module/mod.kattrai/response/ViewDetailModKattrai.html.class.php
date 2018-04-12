<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKattrai extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkattrai.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKattrai = GtfwDispt()->load->business('ModKattrai', 'mod.kattrai');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKattrai->getDetailModKattrai($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kattrai', 'ModKattrai', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKattrai';
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