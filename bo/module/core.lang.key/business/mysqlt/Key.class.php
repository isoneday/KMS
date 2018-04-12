<?php

/**
 * @author GTFW CRUD Generator 
 */
class Key extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.lang.key/business/mysqlt/key.sql.php');
        $this->SetDebugOn();
    }

    public function countKey() {
        $query = $this->mSqlQueries['count_key'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getKey($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($code)) {
            $str .= " AND LOWER(key_code) LIKE('%$code%')";
            $str .= " OR key_id IN 
				  (SELECT DISTINCT 
					key_text_key_id AS id 
				  FROM
					gtfw_key_text 
				  WHERE LOWER(key_text_key_text) LIKE LOWER('%$code%')) ";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_key'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailKey($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_key'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function insertKey($params) {
        return $this->Execute($this->mSqlQueries['insert_key'], $params);
    }

    public function updateKey($params) {
        return $this->Execute($this->mSqlQueries['update_key'], $params);
    }

    public function deleteKey($id) {
        return $this->Execute($this->mSqlQueries['delete_key'], array($id));
    }

    public function getLang() {
        return $this->Open($this->mSqlQueries['get_lang'], array());
    }

    public function getLangByKey($id) {
        return $this->Open($this->mSqlQueries['get_lang_by_key'], array($id));
    }

    public function getKeyText() {
        return $this->Open($this->mSqlQueries['get_key_text'], array());
    }

    public function insertKeyText($params) {
        return $this->Execute($this->mSqlQueries['insert_key_text'], $params);
    }

    public function updateKeyText($params) {
        return $this->Execute($this->mSqlQueries['update_key_text'], $params);
    }

    public function deleteKeyText($id) {
        return $this->Execute($this->mSqlQueries['delete_key_text'], array($id));
    }

    /**
     * get keys => values by prefix
     * currently for validation library
     * @param string prefix_
     */
    public function getKeyByPrefix($prefix) {
        $lang = GtfwLang()->GetLangCode();
        $result = $this->Open($this->mSqlQueries['get_key_by_prefix'], array($lang, $prefix . '%'));
        if (!empty($result)) {
            foreach ($result as $val) {
                $return[str_replace($prefix, '', $val['code'])] = $val['text'];
            }
            return $return;
        }
    }

    public function checkKey($value, $id) {
        $return = false;
        $str = '';
        if (!empty($id))
            $str = " AND key_id != $id";
        $query = str_replace('--filter--', $str, $this->mSqlQueries['check_key']);
        $result = $this->Open($query, array($value));
        if (!empty($result))
            $return = true;
        return $return;
    }

}

// End of file Key.class.php