<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailUnit extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_unit.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjUnit = GtfwDispt()->load->business('Unit', 'core.unit');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjUnit->getDetailUnit($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('core.unit', 'unit', 'view', 'html').'&display';
        $nav[0]['menu'] = 'Unit';
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