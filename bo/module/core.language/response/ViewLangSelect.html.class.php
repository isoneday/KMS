<?php
/**
 * @author Prima Noor 
 */
   
class ViewLangSelect extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/core.language/template');
      	$this->SetTemplateFile('view_lang_select.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        
        $lang = $ObjLang->listLangCode();
        
        $currLang = GtfwLang()->GetLangCode();
        
      	return compact('lang', 'currLang');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        $this->mrTemplate->addVar('content', 'CURRLANG', $currLang);
        
        if (!empty($lang)) {
            foreach ($lang as $val) {
                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
            }
        }
   	}
}
?>