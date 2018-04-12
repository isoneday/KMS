<?php
/**
 * @author Prima Noor 
 */
   
class ViewChangePassword extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_change_password.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $msg = Messenger::Instance()->Receive(__FILE__);        
		$message['content'] = isset($msg[0][1])?$msg[0][1]:NULL;
		$message['style'] = isset($msg[0][2])?$msg[0][2]:NULL;
      	return compact('message');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.user', 'changePassword', 'do', 'json'));
   	}
}
?>