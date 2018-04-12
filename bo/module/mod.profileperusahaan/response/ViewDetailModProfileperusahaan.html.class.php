<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModProfileperusahaan extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modprofileperusahaan.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModProfileperusahaan = GtfwDispt()->load->business('ModProfileperusahaan', 'mod.profileperusahaan');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModProfileperusahaan->getDetailModProfileperusahaan($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.profileperusahaan', 'ModProfileperusahaan', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModProfileperusahaan';
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