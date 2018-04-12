<?php
/**
* @author Prima Noor 
*/

class ViewSearchMenu extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.Dispatcher::Instance()->mModule.'/template');
        $this->SetTemplateFile('view_search_menu.html');
    }

    function ProcessRequest()
    {    
    	$ObjMenu = Dispatcher::Instance()->load->business('CompMenu', 'comp.menu');

		$type = $_GET['type']->Raw();
		$key = $_GET['key']->Raw();
		$result = $ObjMenu->listMenu(array('name' => $key));

		if ($type == 'json') {
			if (!empty($result)) {
				$tmp = array();
				foreach ($result as $key => $value) {
					$tmp[$key] = trim($value['title']);
	                if (!empty($value['mod'])) {
	                    $result[$key]['url'] = Dispatcher::Instance()->GetUrl($value['mod'], $value['sub'], $value['act'], $value['typ']).'&mId='.$value['id'];                
	                } else {
	                    $result[$key]['url'] = Dispatcher::Instance()->GetUrl('core.home', 'home', 'view', 'html').'&mId='.$value['id'];
	                }
	                if (empty($result[$key]['icon_small'])) $result[$key]['icon_small'] = 'default_small.png';
	                unset($result[$key]['id']);
	                unset($result[$key]['parent_id']);
	                unset($result[$key]['position']);
	                unset($result[$key]['mod']);
	                unset($result[$key]['sub']);
	                unset($result[$key]['act']);
	                unset($result[$key]['typ']);
	                unset($result[$key]['icon']);
	                // unset($result[$key]['icon_small']);
	                unset($result[$key]['icon_large']);
				}
				asort($tmp);
				$menus = array();
				foreach ($tmp as $key => $value) {
					$menus[] = $result[$key];
				}
				echo json_encode($menus);
			}
			exit;
		}
		$menu = $result;

        return compact('menu');
    }

    function ParseTemplate($data = NULL)
    {
        if (is_array($data))
            extract($data);
        
        if (!empty($menu)) {
            foreach ($menu as $val) {
                if (empty($val['icon'])) {
                    $val['icon'] = 'default.png';
                }
                if (empty($val['mod'])) {
                    $val['url'] = GtfwDispt()->GetUrl('core.home', 'home', 'view', 'html').'&mId='.$val['id'];
                } else {
                    $val['url'] = GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']).'&mId='.$val['id'];
                }
                $this->mrTemplate->addVars('icon_menu', $val);
                $this->mrTemplate->parseTemplate('icon_menu', 'a');
            }
        }

    }
}
?>