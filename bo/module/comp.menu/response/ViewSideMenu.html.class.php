<?php

class ViewSideMenu extends HtmlResponse
{

    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/comp.menu/template');
        $this->SetTemplateFile('view_side_menu.html');
    }

    function ProcessRequest()
    {
        $Obj = GtfwDispt()->load->business("CompMenu", "comp.menu");
        
        $mmId = $_COOKIE['mmId']->Integer()->Raw();
        
        if (!empty($mmId)) {
            $mId = $mmId;
        } elseif (!empty($_GET['mmId'])) {
            $mId = $_GET['mmId']->Integer()->Raw();
            $_SESSION['mmId'] = $mId;
            # set cookie
            $myDomain = preg_replace('/^[^\.]*\.([^\.]*)\.(.*)$/', '/\1.\2/', $_SERVER['HTTP_HOST']);
            $setDomain = ($_SERVER['HTTP_HOST']) != "localhost" ? ".$myDomain" : false;
            setcookie("mmId", $mId, time() + 3600 * 24 * (2), '/', "$setDomain", 0);
        } elseif(!empty($_SESSION['mmId'])) {
            $mId = $_SESSION['mmId'];
        } else {
            $mId = 0;
        }

        $menu = $Obj->listMenu();
		
        if (!empty($menu)) {
            foreach ($menu as $key => $val) {
                if (!empty($val['mod'])) {
                    $menu[$key]['link'] = GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']).'&mId='.$val['id'];                
                } else {
                    $menu[$key]['link'] = GtfwDispt()->GetUrl('core.home', 'home', 'view', 'html').'&mId='.$val['id'];
                }
            }
        }

        $root = $mId;

        return compact('menu', 'root');
    }

    function ParseTemplate($data = null)
    {
        if (is_array($data)) {
            extract($data);
        }
        if (!empty($menu)) {
            $htmlMenu = $this->getMenu($menu, $root);
            $this->mrTemplate->addVar('content', 'MENU', $htmlMenu);
        }
    }

    /**
     * generate block ul menu
     * @param array $items(id, parent_id, title, link, position)
     * 
     **/
    function getMenu($items, $root_id = 0)
    {
        $this->html = array();
        $this->items = $items;

        foreach ($this->items as $item)
            $children[$item['parent_id']][] = $item;

        // loop will be false if the root has no children (i.e., an empty menu!)
        $loop = !empty($children[$root_id]);

        // initializing $parent as the root
        $parent = $root_id;
        $parent_stack = array();

        $tmp = $this->getChildrenId($children, $parent);
        $childrenId = explode('|', $tmp);

        // HTML wrapper for the menu (open)
        $this->html[] = '<ul class="clearfix">';

        while ($loop && (($option = each($children[$parent])) || ($parent > $root_id) || (in_array($parent, $childrenId)))) {
            if ($option === false) {
                $parent = array_pop($parent_stack);

                // HTML for menu item containing childrens (close)
                $this->html[] = str_repeat("\t", (count($parent_stack) + 1) * 2) . '</ul>';
                $this->html[] = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1) . '</li>';
            } elseif (!empty($children[$option['value']['id']])) {
                $tab = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1);

                // HTML for menu item containing childrens (open)
                $this->html[] = sprintf('%1$s<li class="sidebar_ul_'.$option['value']['parent_id'].'"><a class="xhr dest_subcontent-element side_menu" href="%2$s"><img src="assets/images/btn/%4$s"><span class="menu-label">%3$s</span></a><span class="icon">&nbsp;</span>', 
                    $tab, // %1$s = tabulation
                    $option['value']['link'], // %2$s = link (URL)
                    $option['value']['title'], // %3$s = title
                    empty($option['value']['icon_small']) ? 'default_small.png' : $option['value']['icon_small'] // %4$s = icon
                    );
                $this->html[] = $tab . "\t" . '<ul class="submenu" id="sidebar_ul_'.$option['value']['id'].'">';

                array_push($parent_stack, $option['value']['parent_id']);
                $parent = $option['value']['id'];
            } else { // HTML for menu item with no children (aka "leaf")
                $tab = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1);
                $this->html[] = sprintf('%1$s<li class="sidebar_ul_'.$option['value']['parent_id'].'"><a class="xhr dest_subcontent-element side_menu" href="%2$s"><img src="assets/images/btn/%4$s"><span class="menu-label">%3$s</span></a></li>', $tab, // %1$s = tabulation
                    $option['value']['link'], // %2$s = link (URL)
                    $option['value']['title'], // %3$s = title
                    empty($option['value']['icon_small']) ? 'default_small.png' : $option['value']['icon_small'] // %4$s = icon
                    );
            }
        }

        // HTML wrapper for the menu (close)
        $this->html[] = '</ul>';

        return implode("\r\n", $this->html);
    }

    function getChildrenId($items, $parent)
    {
        $result = '';

        foreach ($items as $key => $val) {
            if ($key == $parent) {
                foreach ($val as $value) {
                    $result .= $value['id'] . '|';
                    if (!empty($items[$value['id']])) {
                        $result = $result . $this->getChildrenId($items, $value['id']) . '|';
                    }
                }
            }
        }

        return substr($result, 0, -1);
    }

}

?>
