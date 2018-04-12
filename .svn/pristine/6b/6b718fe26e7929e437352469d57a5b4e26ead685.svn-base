<?php

/**
 * @author GTFW CRUD Generator 
 */
class SmsTemplate extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/comp.sms.template/business/mysqlt/smstemplate.sql.php');
        $this->SetDebugOn();
    }

    public function countSmsTemplate() {
        $query = $this->mSqlQueries['count_smstemplate'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getSmsTemplate($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($subject)) {
            $str .= " AND LOWER(smstmpl_subject) LIKE ('%$subject%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_smstemplate'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailSmsTemplate($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_smstemplate'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getDetailSmsTemplateBody($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_smstemplate_body'], array($id));
        if (!empty($result)) {
            foreach ($result as $val) {
                $return[$val['code']] = $val['text'];
            }
            return $return;
        }
    }

    public function insertSmsTemplate($params) {
        return $this->Execute($this->mSqlQueries['insert_smstemplate'], $params);
    }

    public function insertSmsTemplateText($params) {
        return $this->Execute($this->mSqlQueries['insert_smstemplate_text'], $params);
    }

    public function updateSmsTemplate($params) {
        return $this->Execute($this->mSqlQueries['update_smstemplate'], $params);
    }

    public function deleteSmsTemplate($id) {
        return $this->Execute($this->mSqlQueries['delete_smstemplate'], array($id));
    }

    public function deleteSmsTemplateText($id) {
        return $this->Execute($this->mSqlQueries['delete_smstemplate_text'], array($id));
    }

    public function listSmsTemplate() {
        return $this->Open($this->mSqlQueries['list_smstemplate'], array());
    }

}

// End of file SmsTemplate.class.php