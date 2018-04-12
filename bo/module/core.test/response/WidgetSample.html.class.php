<?php
/**
 * @author Prima Noor 
 */
   
class WidgetSample extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/core.test/template');
      	$this->SetTemplateFile('widget_sample.html');
   	}
   
   	function ProcessRequest()
   	{
   	    $ObjTest = GtfwDispt()->load->business('CoreTest', 'core.test');
        
        $data = $ObjTest->getPersentaseKegagalan();
        
      	return compact('data');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($data)) {
            $this->mrTemplate->addVar('content', 'DATA', $data);
        }
   	}
}
?>