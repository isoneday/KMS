<?php

/**
 * @author GTFW CRUD Generator 
 */
class CoreUserall extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.userall/business/mysqlt/coreuserall.sql.php');
        $this->SetDebugOn();
    }

    public function countCoreUserall() {
        $query = $this->mSqlQueries['count_coreuserall'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getCoreUserall($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($real_name)) {
            $str .= " AND LOWER(a.user_real_name) LIKE('%$real_name%')";
        }
        if (!empty($name)) {
            $str .= " AND LOWER(a.user_user_name) LIKE('%$name%')";
        }
        if (!empty($group) && $group != 'all') {
            $str .= " AND c.`usergroup_group_id` IN ('$group')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_coreuserall'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailCoreUserall($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_coreuserall'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getUserGroup($id) {
        return $this->Open($this->mSqlQueries['get_user_group'], array($id));
    }

    public function insertCoreUserall($params) {
        return $this->Execute($this->mSqlQueries['insert_coreuserall'], $params);
    }

    public function addUserGroup($params) {
        return $this->Execute($this->mSqlQueries['add_user_group'], $params, NULL, false);
    }

    public function updateCoreUserall($params) {
        return $this->Execute($this->mSqlQueries['update_coreuserall'], $params);
    }

    public function deleteCoreUserall($id) {
        return $this->Execute($this->mSqlQueries['delete_coreuserall'], array($id));
    }

    public function deleteUserGroup($userId) {
        return $this->Execute($this->mSqlQueries['delete_user_group'], array($userId));
    }

    public function listCoreUserall() {
        return $this->Open($this->mSqlQueries['list_coreuserall'], array());
    }

}

// End of file CoreUserall.class.php