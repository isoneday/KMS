<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModMeeting extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modmeeting.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModMeeting = GtfwDispt()->load->business('ModMeeting', 'mod.meeting');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModMeeting->getDetailModMeeting($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.meeting', 'ModMeeting', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModMeeting';
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