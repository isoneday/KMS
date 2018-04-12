<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailSetting extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_setting.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');
        
        $id = Dispatcher::Instance()->Decrypt ($_GET['id']->Raw());
        
        $detail = $ObjSetting->getDetailSetting($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('core.setting', 'setting', 'view', 'html').'&display';
        $nav[0]['menu'] = 'Setting';
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