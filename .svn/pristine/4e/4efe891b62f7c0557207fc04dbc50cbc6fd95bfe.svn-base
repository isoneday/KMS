<?php

/**
 * @author GTFW CRUD Generator 
 */
class Group extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.group/business/mysqlt/group.sql.php');
        $this->appId = GtfwCfg('application', 'application_id');
        $this->SetDebugOn();
    }

    public function countGroup() {
        $query = $this->mSqlQueries['count_group'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getGroup($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(group_name) LIKE('%$name%')";
        }
        $limit = '';
        if (!empty($start) AND !empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_group'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array($this->appId));
        return $result;
    }

    public function getDetailGroup($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_group'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function insertGroup($params) {
        return $this->Execute($this->mSqlQueries['insert_group'], $params);
    }

    public function updateGroup($params) {
        return $this->Execute($this->mSqlQueries['update_group'], $params);
    }

    public function deleteGroup($id) {
        return $this->Execute($this->mSqlQueries['delete_group'], array($id));
    }

    public function getMenuList() {
        $appId = GtfwCfg('application', 'application_id');
        $lang = GtfwLang()->GetLangCode();

        return $this->Open($this->mSqlQueries['get_menu_list'], array($appId, $lang));
    }

    public function getAccessGroup($id) {
        return $this->Open($this->mSqlQueries['get_access_group'], array($id));
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

    public function listGroup() {
        $appId = GtfwCfg('application', 'application_id');
        return $this->Open($this->mSqlQueries['list_group'], array($appId));
    }

    public function listGroupToEmployee($appId) {
        return $this->Open($this->mSqlQueries['list_group_to_employee'], array($appId));
    }

    public function getActionList() {
        return $this->Open($this->mSqlQueries['get_action_list'], array(GtfwLang()->GetLangCode()));
    }
    
    public function checkGroupUsed($id)
    {
        $return = false;
        $result = $this->Open($this->mSqlQueries['chek_group_used'], array($id));
        if (!empty($result)) $return = true;
        return $return;
    }

}

// End of file Group.class.php