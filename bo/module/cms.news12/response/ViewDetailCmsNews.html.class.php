<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailCmsNews extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_cmsnews.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjCmsNews = GtfwDispt()->load->business('CmsNews', 'cms.news');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjCmsNews->getDetailCmsNews($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('cms.news', 'CmsNews', 'view', 'html').'&display';
        $nav[0]['menu'] = 'CmsNews';
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