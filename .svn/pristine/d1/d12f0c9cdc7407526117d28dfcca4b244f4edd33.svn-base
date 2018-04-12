<?php
/**
 * @author Prima Noor 
 */
   
class ViewWidgetContainer extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_widget.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjTest = GtfwDispt()->load->business('CoreTest', 'core.test');
   	    $mId = $ObjTest->getModuleMenuId('core.test', 'widgetContainer');
        Messenger::Instance()->Send('core.widget', 'widget', 'view', 'html', array($mId), Messenger::CurrentRequest);
        
        		
		$nav[0]['url'] = '';
        $nav[0]['menu'] = '';
        $title = "Dashboard";
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', 'hidden', ''), Messenger::CurrentRequest);
        
      	return NULL;
   	}
}
?>