<?php
/**
 * @author Prima Noor 
 */
   
class ViewUser extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_user.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjSample = Dispatcher::Instance()->load->business('Sample', 'core.sample');
        
        $user = $ObjSample->getUser();
        echo '<pre>'; print_r($user); echo '</pre>';
        
      	return compact('user');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
   	}
}
?>