<?php
/**
 * @author Prima Noor 
 */
   
class ViewSample extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_sample.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $links = array(
            array(
                'name'  => 'Input Type',
                'url'   => Dispatcher::Instance()->GetUrl('core.sample', 'input', 'view', 'html'),
            ),    
            array(
                'name'  => 'Pdf',
                'url'   => Dispatcher::Instance()->GetUrl('core.sample', 'pdf', 'view', 'html'),
                'ajax'  => false
            ),    
            array(
                'name'  => 'Upload',
                'url'   => Dispatcher::Instance()->GetUrl('core.sample', 'upload', 'view', 'html')
            ),      
            array(
                'name'  => 'Excel',
                'url'   => Dispatcher::Instance()->GetUrl('core.sample', 'excel', 'view', 'html'),
                'ajax'  => false
            ),     
            array(
                'name'  => 'Excel Import',
                'url'   => Dispatcher::Instance()->GetUrl('core.sample', 'excelImport', 'view', 'html'),
            ),  
            array(
                'name'  => 'Excel Chart',
                'url'   => Dispatcher::Instance()->GetUrl('core.sample', 'excelChart', 'view', 'html'),
                'ajax'  => false
            ), 
        );
      	return compact('links');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($links)) {
            foreach ($links as $val) {
              if (isset($val['ajax']) AND $val['ajax'] === false)
                $val['class'] = '';
              else 
                $val['class'] = 'xhr dest_subcontent-element';
              $this->mrTemplate->addVars('links', $val);
              $this->mrTemplate->parseTemplate('links', 'a');
            }
        }
   	}
}
?>