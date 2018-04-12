<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailTermCondition extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_termcondition.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjTermCondition = GtfwDispt()->load->business('TermCondition', 'cms.term.condition');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjTermCondition->getDetailTermCondition($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('cms.term.condition', 'TermCondition', 'view', 'html').'&display';
        $nav[0]['menu'] = 'TermCondition';
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
        $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('cms.term.condition', 'updateTermCondition', 'view', 'html').'&id='.$detail['id']);
   	}
}
?>