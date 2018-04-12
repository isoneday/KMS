<?php

/**
 * @author GTFW CRUD Generator 
 */
class EmailTemplate extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/comp.email.template/business/mysqlt/emailtemplate.sql.php');
        $this->SetDebugOn();
    }

    public function countEmailTemplate() {
        $query = $this->mSqlQueries['count_emailtemplate'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getEmailTemplate($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($subject)) {
            $str .= " AND LOWER(emailtmpl_subject) LIKE('%$subject%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_emailtemplate'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailEmailTemplate($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_emailtemplate'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getDetailEmailTemplateBody($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_emailtemplate_body'], array($id));
        if (!empty($result)) {
            foreach ($result as $val) {
                $return[$val['code']] = $val['text'];
            }
            return $return;
        }
    }

    public function getDetailEmailTemplateAltBody($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_emailtemplate_altbody'], array($id));
        if (!empty($result)) {
            foreach ($result as $val) {
                $return[$val['code']] = $val['text'];
            }
            return $return;
        }
    }

    public function insertEmailTemplate($params) {
        return $this->Execute($this->mSqlQueries['insert_emailtemplate'], $params);
    }

    public function insertEmailTemplateText($params) {
        $result = $this->Execute($this->mSqlQueries['insert_emailtemplate_text'], $params);

        return $result;
    }

    public function updateEmailTemplate($params) {
        return $this->Execute($this->mSqlQueries['update_emailtemplate'], $params);
    }

    public function deleteEmailTemplate($id) {
        return $this->Execute($this->mSqlQueries['delete_emailtemplate'], array($id));
    }

    public function deleteEmailTemplateText($id) {
        return $this->Execute($this->mSqlQueries['delete_emailtemplate_text'], array($id));
    }

    public function listEmailTemplate() {
        return $this->Open($this->mSqlQueries['list_emailtemplate'], array());
    }

}

// End of file EmailTemplate.class.php