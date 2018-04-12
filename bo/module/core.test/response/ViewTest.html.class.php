<?php
/**
 * @author Prima Noor 
 */
   
class ViewTest extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_test.html');
   	}
   
   	function ProcessRequest()
   	{	
      	return compact('');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        $links = array(
            array(
                'title' => 'Widget',
                'url'   => GtfwDispt()->GetUrl('core.test', 'widgetContainer', 'view', 'html')
            )
        );
        foreach ($links as $val) {
            $this->mrTemplate->addVars('links', $val);
            $this->mrTemplate->parseTemplate('links', 'a');
        }
        
   	}
}
?>