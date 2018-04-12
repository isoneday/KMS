<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModTraining extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modtraining.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModTraining = GtfwDispt()->load->business('ModTraining', 'mod.training');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModTraining->getDetailModTraining($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.training', 'ModTraining', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModTraining';
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