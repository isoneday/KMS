<?php

/**
 * @author Prima Noor 
 */

class ViewInputGroup extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_group.html');
    }

    function ProcessRequest()
    {
        $ObjGroup = GtfwDispt()->load->business('Group', 'core.group');

        $id = $_GET['id']->Integer()->Raw();

        $msg = Messenger::Instance()->Receive(__file__);
        
        $post = isset($msg[0][0]) ? $msg[0][0] : null;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : null;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : null;

        $access = array();
        $action = array();
        if (!empty($post)) {
            if (!empty($post['access'])) {
                $acc = $post['access'];
                unset($post['access']);
                $access = explode(',', $acc);
            }
            if (!empty($post['action'])) {
                $action = $post['action'];
                unset($post['action']);
            }
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjGroup->getDetailGroup($id);
            $result = $ObjGroup->getAccessGroup($id);
            foreach ($result as $val) {
                $access[] = $val['menu_id'];
                $tmp = explode(',', $val['actions']);
                if (!empty($tmp)) {
                    foreach ($tmp as $act) {
                        $action[$val['menu_id']][$act] = $act;
                    }
                }
            }
        }
        
        $menuList = $ObjGroup->getMenuList();
        
        $actionList = $ObjGroup->getActionList();
        
        if (!empty($menuList)) {
            $list = array();
            foreach ($menuList as $val) {
                $list[] = array(
                    'id'    => $val['id'],
                    'parent_id' => $val['parent_id'],
                    'title' => $val['name'],
                    'action_id' => $val['action'],
                    'action_name' => (empty($val['action'])?'':(' <em>('.$val['action_name'].')</em>')),
                    'link'  => GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']),
                    'position' => $val['order']                    
                );  
            }
        }
        $menu = $this->getMenu($list, 0, $access, $action, $actionList);
        		
		$nav[0]['url'] = GtfwDispt()->GetUrl('core.group', 'group', 'view', 'html').'&display';
        $nav[0]['menu'] = GtfwLangText('group');
        $title = (empty($id)?GtfwLangText('add'):GtfwLangText('edit'));
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'menuList', 'menu');
    }

    function ParseTemplate($rdata = null)
    {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }
        if (!empty($menu)) {
            $this->mrTemplate->addVar('content', 'MENU', $menu);
        }

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('core.group', 'group', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.group', (empty($id) ? 'add' : 'update') . 'Group', 'do', 'json').(empty($id) ? '' : ('&id='.$id)));
    }

    /**
     * generate block ul menu
     * @param array $items(id, parent_id, title, link, position)
     * 
     **/
    function getMenu($items, $root_id = 0, $data = NULL, $action, $actionList)
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
                                .'<li id="'.$option['value']['id'].'" class="">'
                                .'<a>'
                                .$option['value']['title']
                                .'</a>';
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
                            if (!empty($action[$option['value']['id']]) AND is_array($action[$option['value']['id']]) AND in_array($value, $action[$option['value']['id']])) $allow = true;
                            $act .= '<label class="checkbox"><input class="check_action" id="check_'.$option['value']['id'].'_'.$value.'" type="checkbox" name="action['.$option['value']['id'].']['.$value.']" value="'.$value.'" '.($allow?'checked="checked"':'').'/> '.$val['name'].'</label>'; // name="act[menu_id][action_id]"
                            $label[] = '<span class="'.($allow?'':'label-disabled').'" id="label_'.$option['value']['id'].'_'.$value.'">'.$val['name'].'</span>'; // span id="label_menuid_actionid"
                        }
                    }                    
                }
                $act .= '</div>';
                $this->html[] = $tab
                                .'<li id="'.$option['value']['id'].'" class="'.(in_array($option['value']['id'], $data)?'jstree-checked':'jstree-unchecked').'">'
                                .'<div id="data_'.$option['value']['id'].'" class="modal hide my-modal">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3>'.$actionLabel.'</h3>
                                    </div>
                                    <div class="modal-body">'.$act.'</div>
                                 </div>'
                                .'<a data-toggle="modal" data-original-title="Action" href="#data_'.$option['value']['id'].'" data-menuid="'.$option['value']['id'].'">'
                                .$option['value']['title'].(!empty($label)?' ('.implode(', ', $label).')':'')
                                .'</a>'
                                .'</li>';
            }
        }

        // HTML wrapper for the menu (close)
        $this->html[] = '</ul>';

        return implode("\r\n", $this->html);
    }
}

?>