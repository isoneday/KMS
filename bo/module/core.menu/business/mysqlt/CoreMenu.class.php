<?php

/**
 * @author Prima Noor 
 */
class CoreMenu extends Database {

    function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.menu/business/mysqlt/coremenu.sql.php');
        $this->appId = GtfwCfg('application', 'application_id');
        $this->lang = GtfwLang()->GetLangCode();
        $this->SetDebugOn();
    }

    function countData() {
        $query = $this->mSqlQueries['count_data'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    function getData($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';
        if (!empty($name)) {
            $str .= " AND LOWER(mt.menutext_menu_name) LIKE LOWER('%%$name%%')";
        }
        if (!empty($parent)) {
            $str .= " AND m.menu_parent_id = $parent";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = str_replace('--search--', $str, $this->mSqlQueries['get_data']);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array($lang, $this->appId));

        return $result;
    }

    function getDetail($id) {
        $result = $this->Open($this->mSqlQueries['get_detail'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getMenuText($id) {
        $result = $this->Open($this->mSqlQueries['get_menu_text'], array($id));
        if (!empty($result)) {
            foreach ($result as $val) {
                $return[$val['code']] = $val['text'];
            }
            return $return;
        }
    }

    public function getMenuTextDesc($id) {
        $result = $this->Open($this->mSqlQueries['get_menu_text_desc'], array($id));
        if (!empty($result)) {
            foreach ($result as $val) {
                $return[$val['code']] = $val['text'];
            }
            return $return;
        }
    }

    public function deleteMenuText($id) {
        return $this->Execute($this->mSqlQueries['delete_menu_text'], array($id));
    }

    public function listParent($lang) {
        return $this->Open($this->mSqlQueries['list_parent'], array($lang));
    }

    public function addMenu($params) {
        return $this->Execute($this->mSqlQueries['add_menu'], $params);
    }

    public function addMenuText($params) {
        return $this->Execute($this->mSqlQueries['add_menu_text'], $params);
    }

    public function listMenu() {
        $result = $this->Open($this->mSqlQueries['list_menu'], array(GtfwLang()->GetLangCode(), $this->appId));
        if (!empty($result)) {
            return $this->getMenu($result);
        }
    }

    public function edit($params) {
        return $this->Execute($this->mSqlQueries['update_menu'], $params);
    }

    public function deleteMenu($id) {
        $this->StartTrans();
        $result = $this->Execute($this->mSqlQueries['delete_menu_text'], array($id));
        $result = $result and $this->Execute($this->mSqlQueries['delete_menu'], array($id));
        $this->EndTrans($result);
        return $result;
    }

    function getMenu($items, $root_id = 0) {
        $this->html = array();
        $this->items = $items;

        foreach ($this->items as $item)
            $children[$item['parent_id']][] = $item;

        // loop will be false if the root has no children (i.e., an empty menu!)
        $loop = !empty($children[$root_id]);

        // initializing $parent as the root
        $parent = $root_id;
        $parent_stack = array();

        while ($loop && (($option = each($children[$parent])) || ($parent > $root_id))) {
            if ($option === false) {
                $parent = array_pop($parent_stack);
            } elseif (!empty($children[$option['value']['id']])) {
                $tab = str_repeat("&nbsp;&nbsp;", (count($parent_stack) + 1) * 2 - 2);

                // menu item containing childrens (open)
                $this->html[] = array(
                    'id' => $option['value']['id'],
                    'name' => $tab . $option['value']['name']
                );

                array_push($parent_stack, $option['value']['parent_id']);
                $parent = $option['value']['id'];
            } else {
                $tab = str_repeat("&nbsp;&nbsp;", (count($parent_stack) + 1) * 2 - 2);
                // menu item with no children (aka "leaf")

                $this->html[] = array(
                    'id' => $option['value']['id'],
                    'name' => $tab . $option['value']['name']
                );
            }
        }

        return $this->html;
    }

}

?>