<?php
/**
 * @author Prima Noor 
 */
   
class ViewProfile extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_profile.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjUser = GtfwDispt()->load->business('User', 'core.user');
        
        $userId = Security::Authentication()->GetCurrentUser()->GetUserId();
        
        $detail = $ObjUser->getDetailUser($userId);
        
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