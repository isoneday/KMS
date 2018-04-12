<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailUser extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_user.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjUser = GtfwDispt()->load->business('User', 'core.user');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjUser->getDetailUser($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('core.user', 'user', 'view', 'html').'&display';
        $nav[0]['menu'] = 'User';
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