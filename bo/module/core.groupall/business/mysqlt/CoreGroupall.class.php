<?php

/**
 * @author GTFW CRUD Generator 
 */
class CoreGroupall extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.groupall/business/mysqlt/coregroupall.sql.php');
        $this->SetDebugOn();
    }

    public function countCoreGroupall() {
        $query = $this->mSqlQueries['count_coregroupall'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getCoreGroupall($filter = NULL) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(group_name) LIKE('%$name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_coregroupall'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailCoreGroupall($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_coregroupall'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function insertCoreGroupall($params) {
        return $this->Execute($this->mSqlQueries['insert_coregroupall'], $params);
    }

    public function updateCoreGroupall($params) {
        return $this->Execute($this->mSqlQueries['update_coregroupall'], $params);
    }

    public function deleteCoreGroupall($id) {
        return $this->Execute($this->mSqlQueries['delete_coregroupall'], array($id));
    }

    public function listApplication() {
        return $this->Open($this->mSqlQueries['list_application'], array());
    }

    public function getAccessGroup($id) {
        return $this->Open($this->mSqlQueries['get_access_group'], array($id));
    }

    public function getMenuList($appId = NULL) {
        $lang = $this->Open($this->mSqlQueries['get_default_lang'], array('default_lang'));
        $result = $this->Open($this->mSqlQueries['get_menu_list'], array($appId, $lang[0]['value'], $lang[0]['value']));  
        return $result;
    }

    public function getActionList() {
        $lang = $this->Open($this->mSqlQueries['get_default_lang'], array('default_lang'));
        return $this->Open($this->mSqlQueries['get_action_list'], array($lang[0]['value']));
    }

    /**
     * generate block ul menu
     * @param array $items(id, parent_id, title, link, position)
     * 
     * */
    function getMenu($items, $root_id = 0, $data = NULL, $action, $actionList) {
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
        $this->html[] = '<ul>';

        $actionLabel = 'Aksi';

        while ($loop && (($option = each($children[$parent])) || ($parent > $root_id) || (in_array($parent, $childrenId)))) {
            if ($option === false) {
                $parent = array_pop($parent_stack);

                // HTML for menu item containing childrens (close)
                $this->html[] = str_repeat("\t", (count($parent_stack) + 1) * 2) . '</ul>';
                $this->html[] = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1) . '</li>';
            } elseif (!empty($children[$option['value']['id']])) {
                $tab = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1);

                // HTML for menu item containing childrens (open)
                $this->html[] = $tab
                        . '<li id="' . $option['value']['id'] . '" class="">'
                        . '<a>'
                        . $option['value']['title']
                        . '</a>';
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
                            $act .= '<label class="checkbox"><input class="check_action" id="check_' . $option['value']['id'] . '_' . $value . '" type="checkbox" name="action[' . $option['value']['id'] . '][' . $value . ']" value="' . $value . '" ' . ($allow ? 'checked="checked"' : '') . '/> ' . $val['name'] . '</label>'; // name="act[menu_id][action_id]"
                            $label[] = '<span class="' . ($allow ? '' : 'label-disabled') . '" id="label_' . $option['value']['id'] . '_' . $value . '">' . $val['name'] . '</span>'; // span id="label_menuid_actionid"
                        }
                    }
                }
                $act .= '</div>';
                $this->html[] = $tab
                        . '<li id="' . $option['value']['id'] . '" class="' . (in_array($option['value']['id'], $data) ? 'jstree-checked' : 'jstree-unchecked') . '">'
                        . '<div id="data_' . $option['value']['id'] . '" class="modal hide my-modal">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3>' . $actionLabel . '</h3>
                                    </div>
                                    <div class="modal-body">' . $act . '</div>
                                 </div>'
                        . '<a data-toggle="modal" data-original-title="Action" href="#data_' . $option['value']['id'] . '" data-menuid="' . $option['value']['id'] . '">'
                        . $option['value']['title'] . (!empty($label) ? ' (' . implode(', ', $label) . ')' : '')
                        . '</a>'
                        . '</li>';
            }
        }

        // HTML wrapper for the menu (close)
        $this->html[] = '</ul>';

        return implode("\r\n", $this->html);
    }

    public function insertGroupMenu($params) {
        return $this->Execute($this->mSqlQueries['insert_group_menu'], $params);
    }

    public function insertGroupModuleByMenu($params) {
        $and = '';
        if (!empty($params['actions'])) {
            $and = 'AND md.module_action_id IN (' . $params['actions'] . ')';
        }
        $query = str_replace('--and--', $and, $this->mSqlQueries['insert_group_module_by_menu']);
        return $this->Execute($query, $params);
    }

    public function deleteGroupMenu($groupId) {
        return $this->Execute($this->mSqlQueries['delete_group_menu'], array($groupId));
    }

    public function deleteGroupModule($groupId) {
        return $this->Execute($this->mSqlQueries['delete_group_module'], array($groupId));
    }

    public function checkGroupUsed($id) {
        $return = false;
        $result = $this->Open($this->mSqlQueries['chek_group_used'], array($id));
        if (!empty($result))
            $return = true;
        return $return;
    }

    public function listGroup($appId) {
        return $this->Open($this->mSqlQueries['list_group'], array($appId));
    }

}

// End of file CoreGroupall.class.php