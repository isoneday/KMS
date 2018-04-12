<?php

/**
 * @author GTFW CRUD Generator 
 */
class EmployeeMini extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/emp.employee.mini/business/mysqlt/employeemini.sql.php');
        $this->SetDebugOn();
    }

    public function countEmployeeMini() {
        $query = $this->mSqlQueries['count_employeemini'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getEmployeeMini($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($search_mode) AND $search_mode == 'adv') {
            if (!empty($number)) {
                $str .= " AND (LOWER(emp_number) LIKE('%$number%') OR LOWER(emp_name) LIKE('%$number%'))";
            }
            if (!empty($type_id) && ($type_id != 'all')) {
                $str .= " AND LOWER(f.`emptype_id`) = ('$type_id')";
            }
            if (!empty($status_id) && ($status_id != 'all')) {
                $str .= " AND LOWER(h.`empstat_id`) = ('$status_id')";
            }
            if (!empty($position_id) && ($position_id != 'all')) {
                $str .= " AND LOWER(j.`strucpostype_id`) = ('$position_id')";
            }
            if (!empty($unit_id) && ($unit_id != 'all')) {
                $str .= " AND LOWER(l.`unit_id`) = ('$unit_id')";
            }
        } else {
            if (!empty($s_number)) {
                $str .= 'AND (';
                $str .= "(LOWER(a.emp_number) LIKE('%$s_number%'))";
                $str .= " OR LOWER(a.`emp_name`) LIKE('%$s_number%')";
                $str .= " OR LOWER(f.`emptype_name`) LIKE('%$s_number%')";
                $str .= " OR LOWER(h.`empstat_name`) LIKE('%$s_number%')";
                $str .= " OR LOWER(j.`strucpostype_name`) LIKE('%$s_number%')";
                $str .= " OR LOWER(l.`unit_name`) LIKE('%$s_number%')";
                $str .= ')';
            }
        }

        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_employeemini'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());

        return $result;
    }

    public function getDetailEmployeeMini($filter) {
        $str = '';
        $limit = '';

        if (is_array($filter)) {
            extract($filter);

            if (!empty($search_mode) AND $search_mode == 'adv') {
                if (!empty($number)) {
                    $str .= " AND (LOWER(emp_number) LIKE('%$number%') OR LOWER(emp_name) LIKE('%$number%'))";
                }
                if (!empty($type_id) && ($type_id != 'all')) {
                    $str .= " AND LOWER(f.`emptype_id`) = ('$type_id')";
                }
                if (!empty($status_id) && ($status_id != 'all')) {
                    $str .= " AND LOWER(h.`empstat_id`) = ('$status_id')";
                }
                if (!empty($position_id) && ($position_id != 'all')) {
                    $str .= " AND LOWER(j.`strucpostype_id`) = ('$position_id')";
                }
                if (!empty($unit_id) && ($unit_id != 'all')) {
                    $str .= " AND LOWER(l.`unit_id`) = ('$unit_id')";
                }
            } else {
                if (!empty($s_number)) {
                    $str .= 'AND (';
                    $str .= "(LOWER(a.emp_number) LIKE('%$s_number%'))";
                    $str .= " OR LOWER(a.`emp_name`) LIKE('%$s_number%')";
                    $str .= " OR LOWER(f.`emptype_name`) LIKE('%$s_number%')";
                    $str .= " OR LOWER(h.`empstat_name`) LIKE('%$s_number%')";
                    $str .= " OR LOWER(j.`strucpostype_name`) LIKE('%$s_number%')";
                    $str .= " OR LOWER(l.`unit_name`) LIKE('%$s_number%')";
                    $str .= ')';
                }
            }

            if (!empty($display)) {
                $limit = "LIMIT $start, $display";
            }
        } else {
            $str = "AND a.emp_id = $filter";
        }
        $query = $this->mSqlQueries['get_detail_employeemini'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());

        if ($result) {
            return $result[0];
        }
    }

    public function insertEmployeeMini($params) {
        $result = $this->Execute($this->mSqlQueries['insert_employeemini'], $params);
        return $result;
    }

    public function insertEmpEmail($params) {
        $result = $this->Execute($this->mSqlQueries['insert_emp_email'], $params);
        return $result;
    }

    public function insertEmpStatus($params) {
        $result = $this->Execute($this->mSqlQueries['insert_emp_status'], $params);
        return $result;
    }

    public function insertEmpUnit($params) {
        $result = $this->Execute($this->mSqlQueries['insert_emp_unit'], $params);
        return $result;
    }

    public function insertEmpPosition($params) {
        $result = $this->Execute($this->mSqlQueries['insert_emp_position'], $params);
        return $result;
    }

    public function insertEmpContract($params) {
        $result = $this->Execute($this->mSqlQueries['insert_emp_contract'], $params);
        return $result;
    }

    public function insertFilePhoto($params) {
        return $this->Execute($this->mSqlQueries['insert_file_photo'], $params);
    }

    public function updateEmployeeMini($params) {
        return $this->Execute($this->mSqlQueries['update_employeemini'], $params);
    }

    public function updateEmpEmail($params) {
        $result = $this->Execute($this->mSqlQueries['update_emp_email'], $params);
        return $result;
    }

    public function updateEmpStatus($params) {
        $result = $this->Execute($this->mSqlQueries['update_emp_status'], $params);
        return $result;
    }

    public function updateEmpUnit($params) {
        $result = $this->Execute($this->mSqlQueries['update_emp_unit'], $params);
        return $result;
    }

    public function updateEmpPosition($params) {
        $result = $this->Execute($this->mSqlQueries['update_emp_position'], $params);
        return $result;
    }

    public function updateEmpContract($params) {
        $result = $this->Execute($this->mSqlQueries['update_emp_contract'], $params);
        return $result;
    }

    public function updateFilePhoto($params) {
        return $this->Execute($this->mSqlQueries['update_file_photo'], $params);
    }

    public function deleteEmployeeMini($id) {
        return $this->Execute($this->mSqlQueries['delete_employeemini'], array($id));
    }

    public function listEmployeeMini() {
        return $this->Open($this->mSqlQueries['list_employeemini'], array());
    }

    public function getSetOfficer() {
        return $this->Open($this->mSqlQueries['get_set_officer'], array());
    }

}

// End of file EmployeeMini.class.php