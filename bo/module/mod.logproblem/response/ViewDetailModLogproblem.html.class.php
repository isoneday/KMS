<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModLogproblem extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modlogproblem.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModLogproblem = GtfwDispt()->load->business('ModLogproblem', 'mod.logproblem');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModLogproblem->getDetailModLogproblem($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.logproblem', 'ModLogproblem', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModLogproblem';
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