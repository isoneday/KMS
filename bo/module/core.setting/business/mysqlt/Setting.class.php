<?php

/**
 * @author GTFW CRUD Generator 
 */
class Setting extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.setting/business/mysqlt/setting.sql.php');
        $this->SetDebugOn();
    }

    public function countSetting() {
        $query = $this->mSqlQueries['count_setting'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getSetting($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(setting_name) LIKE('%$name%')";
        }
        if (!empty($value)) {
            $str .= " AND LOWER(setting_value) LIKE('%$value%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_setting'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailSetting($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_setting'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function insertSetting($params) {
        return $this->Execute($this->mSqlQueries['insert_setting'], $params);
    }

    public function updateSetting($params) {
        return $this->Execute($this->mSqlQueries['update_setting'], $params);
    }

    public function deleteSetting($id) {
        return $this->Execute($this->mSqlQueries['delete_setting'], array($id));
    }

    public function getValue($key) {
        $result = $this->Open($this->mSqlQueries['get_setting_value'], array($key));
        if (!empty($result)) {
            return $result[0]['value'];
        }
    }

    public function listApplication() {
        return $this->Open($this->mSqlQueries['list_application'], array());
    }

}

// End of file Setting.class.php