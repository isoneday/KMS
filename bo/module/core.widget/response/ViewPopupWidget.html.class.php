<?php
/**
 * @author Prima Noor 
 */
   
class ViewPopupWidget extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/core.widget/template');
      	$this->SetTemplateFile('view_popup_widget.html');
   	}
   
   	function ProcessRequest()
   	{	
        $menuObj = GtfwDispt()->load->business('CompMenu', 'comp.menu');
        $mId = $_GET['mId']->Integer()->raw();
        $childrenId = NULL;
        
        $ObjWidget = GtfwDispt()->load->business('CoreWidget', 'core.widget');
        if (!empty($mId)) {
            // get all menu for current user
            $all_menu = $menuObj->listMenu();
            if (!empty($all_menu))
            foreach ($all_menu as $item)
                $children[$item['parent_id']][] = $item;
            $tmp = $menuObj->getChildrenId($children, $mId);
            $childrenId = explode('|', $tmp);
        }
        // all widget for current user, current menu id (and its children), exclude displayed widget
        $all_widget = $ObjWidget->listAvailableWidget($mId, $childrenId);
        
      	return compact('all_widget');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        if (!empty($all_widget)) {
            $this->mrTemplate->addVar('widget', 'IS_EMPTY', 'NO');
            foreach ($all_widget as $val) {
                $val['url'] = GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']);
                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
            }
        } else {
            $this->mrTemplate->addVar('widget', 'IS_EMPTY', 'YES');
        }
   	}
}
?>