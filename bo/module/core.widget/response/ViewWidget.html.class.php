<?php
/**
 * @author Prima Noor 
 */
   
class ViewWidget extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/core.widget/template');
      	$this->SetTemplateFile('view_widget.html');
   	}
   
   	function ProcessRequest()
   	{	
        $msg = Messenger::Instance()->Receive(__FILE__);
        
        $mId = !empty($msg[0][0])?$msg[0][0]:null;
        
   	    $ObjWidget = GtfwDispt()->load->business('CoreWidget', 'core.widget');
        // displayed widget
        $user_widget = $ObjWidget->getUserWidget($mId);     
        
      	return compact('user_widget', 'mId');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($user_widget)) {
            foreach ($user_widget as $val) {
                $val['url'] = GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']);
                $this->mrTemplate->addVars('widget', $val);
                $this->mrTemplate->parseTemplate('widget', 'a');
            }
        }
        
        $this->mrTemplate->addVar('content', 'MENU_ID', $mId);
        $this->mrTemplate->addVar('content', 'URL_SAVE_WIDGET', GtfwDispt()->GetUrl('core.widget', 'saveWidget', 'do', 'json'));
        $this->mrTemplate->addVar('content', 'URL_WIDGETS', GtfwDispt()->GetUrl('core.widget', 'popupWidget', 'view', 'html'));
   	}
}
?>