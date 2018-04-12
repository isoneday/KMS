<?php
/**
 * @author Prima Noor 
 */
   
class ViewModuleMenu extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/comp.menu/template');
      	$this->SetTemplateFile('view_module_menu.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $Obj = GtfwDispt()->load->business('CompMenu', 'comp.menu');
        
        $moduleMenu = $Obj->listModuleMenu();
        
      	return compact('moduleMenu');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
   	    if (is_array($rdata))
		  extract($rdata);
          
        if (!empty($moduleMenu)) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            foreach ($moduleMenu as $val) {
                $mod = !empty($val['mod'])?$val['mod']:'core.home';
                $sub = !empty($val['sub'])?$val['sub']:'home';
                $act = !empty($val['act'])?$val['act']:'view';
                $typ = !empty($val['typ'])?$val['typ']:'html';
                $val['url'] = GtfwDispt()->GetUrl($mod, $sub, $act, $typ).'&mmId='.$val['id'];
                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
        
        $this->mrTemplate->addVar('content', 'URL_MENU', GtfwDispt()->GetUrl('comp.menu', 'sideMenu', 'view', 'html'));
   	}
}
?>