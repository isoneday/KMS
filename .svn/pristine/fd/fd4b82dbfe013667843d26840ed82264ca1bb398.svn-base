<?php

/**
 * @author GTFW CRUD Generator 
 */
class User extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.user/business/mysqlt/user.sql.php');
        $this->mApplicationId = Configuration::Instance()->GetValue('application', 'application_id');
        $this->SetDebugOn();
    }

    public function countUser($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($real_name)) {
            $str .= " AND LOWER(user_real_name) LIKE('%$real_name%')";
        }
        if (!empty($name)) {
            $str .= " AND LOWER(user_user_name) LIKE('%$name%')";
        }
        if (!empty($group) AND $group !== 'all') {
            $str .= " AND g.group_id = $group";
        }
        $query = $this->mSqlQueries['count_user'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getUser($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($real_name)) {
            $str .= " AND LOWER(user_real_name) LIKE('%$real_name%')";
        }
        if (!empty($name)) {
            $str .= " AND LOWER(user_user_name) LIKE('%$name%')";
        }
        if (!empty($group) AND $group !== 'all') {
            $str .= " AND g.group_id = $group";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_user'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailUser($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_user'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getUserInfo($id) {
        $result = $this->Open($this->mSqlQueries['get_user_info'], array($id, $this->mApplicationId));
        if ($result) {
            return $result[0];
        }
    }

    public function insertUser($params) {
        return $this->Execute($this->mSqlQueries['insert_user'], $params);
    }

    public function updateUser($params) {
        return $this->Execute($this->mSqlQueries['update_user'], $params);
    }

    public function deleteUser($id) {
        $result = $this->Execute($this->mSqlQueries['delete_user_fav_menu'], array($id));
        if ($result)
            $result = $this->Execute($this->mSqlQueries['delete_user_group'], array($id));
        if ($result)
            $result = $this->Execute($this->mSqlQueries['delete_user_new_pass'], array($id));
        if ($result)
            $result = $this->Execute($this->mSqlQueries['delete_user_unit'], array($id));
        if ($result)
            $result = $this->Execute($this->mSqlQueries['delete_user_whosonline'], array($id));
        if ($result)
            $result = $this->Execute($this->mSqlQueries['delete_user'], array($id));
        return $result;
    }

    public function deleteUserGroup($userId) {
        return $this->Execute($this->mSqlQueries['delete_user_group'], array($userId));
    }

    public function addUserGroup($params) {
        return $this->Execute($this->mSqlQueries['add_user_group'], $params, NULL, false);
    }

    public function checkOldPassword($pass, $userId) {
        $result = $this->Open($this->mSqlQueries['chek_password_user'], array($pass, $userId));
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword($params) {
        return $this->Execute($this->mSqlQueries['change_password'], $params);
    }

}

// End of file User.class.php