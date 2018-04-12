<?php
/**
 * @author Prima Noor 
 */
   
class ViewInput extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(GTFWConfiguration::GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_input.html');
   	}
   
   	function ProcessRequest()
   	{	
      	return compact('');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
   	}
}
?>