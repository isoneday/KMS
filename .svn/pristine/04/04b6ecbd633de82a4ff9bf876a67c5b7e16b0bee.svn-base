<?php

/**
 * @author GTFW CRUD Generator 
 */
class EmployeeUser extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/emp.employee.mini/business/mysqlt/employeeuser.sql.php');
        $this->SetDebugOn();
    }

    public function countEmployeeUser($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($emp_id)) {
            $str .= " AND LOWER(empuser_emp_id) LIKE('%$emp_id%')";
        }
        if (!empty($user_id)) {
            $str .= " AND LOWER(empuser_user_id) LIKE('%$user_id%')";
        }
        $query = $this->mSqlQueries['count_employeeuser'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getEmployeeUser($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($emp_id)) {
            $str .= " AND LOWER(empuser_emp_id) LIKE('%$emp_id%')";
        }
        if (!empty($user_id)) {
            $str .= " AND LOWER(empuser_user_id) LIKE('%$user_id%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_employeeuser'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailEmployeeUser($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_employeeuser'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getApplication() {
        $result = $this->Open($this->mSqlQueries['get_application'], array());
        return $result;
    }

    public function insertUser($params) {
        return $this->Execute($this->mSqlQueries['insert_user'], $params);
    }

    public function insertEmployeeUser($params) {
        $result = $this->Execute($this->mSqlQueries['insert_employeeuser'], $params);
        return $result;
    }

    public function updateUser($params) {
        return $this->Execute($this->mSqlQueries['update_user'], $params);
    }

    public function updateEmployeeUser($params) {
        return $this->Execute($this->mSqlQueries['update_employeeuser'], $params);
    }

    public function deleteEmployeeUser($id) {
        return $this->Execute($this->mSqlQueries['delete_employeeuser'], array($id));
    }

    public function listEmployeeUser() {
        return $this->Open($this->mSqlQueries['list_employeeuser'], array());
    }

    public function addUserGroup($params) {
        $result = $this->Execute($this->mSqlQueries['add_user_group'], $params, NULL, false);
        return $result;
    }

    public function deleteUserGroup($userId) {
        return $this->Execute($this->mSqlQueries['delete_user_group'], array($userId));
    }

    public function getUserData($id) {
        $result = $this->Open($this->mSqlQueries['get_user_data'], array($id));
        return $result[0];
    }

    public function resetPassword($params) {
        $result = $this->Execute($this->mSqlQueries['reset_password'], $params);
        return $result;
    }

    public function getUserIdByEmployee($id) {
        $result = $this->Open($this->mSqlQueries['get_user_id_by_employee'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getUserIdByAssetVarian($id) {
        $result = $this->Open($this->mSqlQueries['get_user_id_by_asset_varian'], array($id));
        if ($result) {
            return $result;
        }
    }

}

// End of file EmployeeUser.class.php