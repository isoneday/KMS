<?php

/**
 * @author Prima Noor 
 */
class ViewDetailCoreGroupall extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_coregroupall.html');
    }

    function ProcessRequest() {
        $ObjCoreGroupall = GtfwDispt()->load->business('CoreGroupall', 'core.groupall');

        $id = $_GET['id']->Integer()->Raw();
        $appId = $_GET['appId']->Integer()->Raw();

        $detail = $ObjCoreGroupall->getDetailCoreGroupall($id);

        if (!empty($id)) {
            $menuList = $ObjCoreGroupall->getMenuList($appId);
            $actionList = $ObjCoreGroupall->getActionList();

            if (!empty($menuList)) {
                $list = array();
                foreach ($menuList as $val) {
                    $list[] = array(
                        'id' => $val['id'],
                        'parent_id' => $val['parent_id'],
                        'title' => $val['name'],
                        'action_id' => $val['action'],
                        'action_name' => (empty($val['action']) ? '' : (' <em>(' . $val['action_name'] . ')</em>')),
                        'link' => GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']),
                        'position' => $val['order']
                    );
                }
            }

            $result = $ObjCoreGroupall->getAccessGroup($id);
            foreach ($result as $val) {
                $access[] = $val['menu_id'];
                $tmp = explode(',', $val['actions']);
                if (!empty($tmp)) {
                    foreach ($tmp as $act) {
                        $action[$val['menu_id']][$act] = $act;
                    }
                }
            }
            if (!empty($list)) {
                $access = $this->generateAccessTree($list, 0, $access, $action, $actionList);
            } else {
                $access = '';
            }
        }
        return compact('detail', 'access');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);
        if (!empty($detail)) {
            $this->mrTemplate->addVars('content', $detail);
        }
        if (!empty($access)) {
            $this->mrTemplate->addVar('content', 'ACCESS', $access);
        }
    }

    /**
     * generate block ul menu
     * @param array $items(id, parent_id, title, link, position)
     * 
     * */
    function generateAccessTree($items, $root_id = 0, $data = NULL, $action, $actionList) {
        $this->html = array();
        $this->items = $items;

        foreach ($this->items as $item)
            $children[$item['parent_id']][] = $item;

        // loop will be false if the root has no children (i.e., an empty menu!)
        $loop = !empty($children[$root_id]);

        // initializing $parent as the root
        $parent = $root_id;
        $parent_stack = array();

        // HTML wrapper for the menu (open)
        $this->html[] = '<ul>';

        $actionLabel = GtfwLangText('action');

        while ($loop && (($option = each($children[$parent])) || ($parent > $root_id))) {
            if ($option === false) {
                $parent = array_pop($parent_stack);

                // HTML for menu item containing childrens (close)
                $this->html[] = str_repeat("\t", (count($parent_stack) + 1) * 2) . '</ul>';
                $this->html[] = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1) . '</li>';
            } elseif (!empty($children[$option['value']['id']])) {
                $tab = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1);

                // HTML for menu item containing childrens (open)
                $this->html[] = $tab
                        . '<li id="' . $option['value']['id'] . '" class="' . (in_array($option['value']['id'], $data) ? '' : 'label-disabled') . '">'
                        . $option['value']['title']
                ;
                $this->html[] = $tab . "\t" . '<ul class="sub">';

                array_push($parent_stack, $option['value']['parent_id']);
                $parent = $option['value']['id'];
            } else {// HTML for menu item with no children (aka "leaf")
                $tab = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1);
                $act = '<div style="padding-left: 10px;">';
                $label = array();
                $actionModule = explode(',', $option['value']['action_id']);
                foreach ($actionList as $val) {
                    foreach ($actionModule as $value) {
                        if ($val['id'] == $value) {
                            $allow = false;
                            if (!empty($action[$option['value']['id']]) AND is_array($action[$option['value']['id']]) AND in_array($value, $action[$option['value']['id']]))
                                $allow = true;
                            $label[] = '<span class="' . ($allow ? '' : 'label-disabled') . '" id="label_' . $option['value']['id'] . '_' . $value . '">' . $val['name'] . '</span>'; // span id="label_menuid_actionid"
                        }
                    }
                }
                $act .= '</div>';
                $this->html[] = $tab
                        . '<li id="' . $option['value']['id'] . '" class="' . (in_array($option['value']['id'], $data) ? '' : 'label-disabled') . '">'
                        . $option['value']['title'] . ' (' . implode(', ', $label) . ')'
                        . '</li>';
            }
        }

        // HTML wrapper for the menu (close)
        $this->html[] = '</ul>';

        return implode("\r\n", $this->html);
    }

}

?>