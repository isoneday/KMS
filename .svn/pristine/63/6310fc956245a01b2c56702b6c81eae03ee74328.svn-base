<?php
/**
 * @author Prima Noor 
 */
   
class ViewMap extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_map.html');
   	}
   
   	function ProcessRequest()
   	{	        
      	return NULL;
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
   	    if (is_array($rdata))
            extract($rdata);
   	}
}
?>