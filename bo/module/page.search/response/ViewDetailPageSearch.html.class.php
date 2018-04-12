<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailPageSearch extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_pagesearch.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjPageSearch = GtfwDispt()->load->business('PageSearch', 'page.search');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjPageSearch->getDetailPageSearch($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('page.search', 'PageSearch', 'view', 'html').'&display';
        $nav[0]['menu'] = 'PageSearch';
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