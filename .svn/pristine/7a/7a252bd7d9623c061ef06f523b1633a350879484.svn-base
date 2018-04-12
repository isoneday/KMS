<?php
/**
 * @author Prima Noor 
 */
   
class ViewInputCompanyProfile extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_input_companyprofile.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjCompanyProfile = GtfwDispt()->load->business('CompanyProfile', 'cms.company.profile');
        
        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();
        
        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0])?$msg[0][0]:NULL;
		$message['content'] = isset($msg[0][1])?$msg[0][1]:NULL;
		$message['style'] = isset($msg[0][2])?$msg[0][2]:NULL;
        
        if (!empty($post)) {
            $input = $post;
        } elseif(!empty($id)) {
            $input = $ObjCompanyProfile->getDetailCompanyProfile($id);
        }
        		
		$nav[0]['url'] = GtfwDispt()->GetUrl('cms.company.profile', 'CompanyProfile', 'view', 'html').'&display';
        $nav[0]['menu'] = GtfwLangText('companyprofile');
        $title = empty($id)?GtfwLangText('add'):GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
                
      	return compact('input', 'id', 'message', 'elmId');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
                
    // echo "<pre>";var_dump($rdata);echo "</pre>";
		if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }
        
        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }
        
        $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('cms.company.profile', 'updateCompanyProfile', 'view', 'html').'&id='.$id);
        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('cms.company.profile', 'detailCompanyProfile', 'view', 'html').'&id='.$id);
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('cms.company.profile', (empty($id)?'add':'update').'CompanyProfile', 'do', 'json') . '&elmId=' . $elmId);
   	}
}
?>