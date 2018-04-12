<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailCompanyProfile extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_companyprofile.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjCompanyProfile = GtfwDispt()->load->business('CompanyProfile', 'cms.company.profile');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjCompanyProfile->getDetailCompanyProfile($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('cms.company.profile', 'CompanyProfile', 'view', 'html').'&display';
        $nav[0]['menu'] = 'CompanyProfile';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
        
      	return compact('detail', 'id');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        // echo "<pre>";var_dump($rdata);echo "</pre>";
        
        if (!empty($detail)) {
            $this->mrTemplate->addVars('content', $detail);
            $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('cms.company.profile', 'updateCompanyProfile', 'view', 'html').'&id='.$detail['id']);
        }
   	}
}
?>