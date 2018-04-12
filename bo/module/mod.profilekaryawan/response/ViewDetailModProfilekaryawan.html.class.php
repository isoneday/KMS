<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModProfilekaryawan extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modprofilekaryawan.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModProfilekaryawan = GtfwDispt()->load->business('ModProfilekaryawan', 'mod.profilekaryawan');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModProfilekaryawan->getDetailModProfilekaryawan($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.profilekaryawan', 'ModProfilekaryawan', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModProfilekaryawan';
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