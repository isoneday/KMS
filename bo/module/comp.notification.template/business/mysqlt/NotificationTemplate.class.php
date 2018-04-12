<?php

/**
 * @author GTFW CRUD Generator 
 */
class NotificationTemplate extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/comp.notification.template/business/mysqlt/notificationtemplate.sql.php');
        $this->SetDebugOn();
    }

    public function countNotificationTemplate() {
        $query = $this->mSqlQueries['count_notificationtemplate'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getNotificationTemplate($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($subject)) {
            $str .= " AND LOWER(notiftmpl_subject) LIKE ('%$subject%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_notificationtemplate'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailNotificationTemplate($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_notificationtemplate'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getDetailNotificationTemplateBody($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_notificationtemplate_body'], array($id));
        if (!empty($result)) {
            foreach ($result as $val) {
                $return[$val['code']] = $val['text'];
            }
            return $return;
        }
    }

    public function getDetailNotificationTemplateAltBody($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_notificationtemplate_altbody'], array($id));
        if (!empty($result)) {
            foreach ($result as $val) {
                $return[$val['code']] = $val['text'];
            }
            return $return;
        }
    }

    public function insertNotificationTemplate($params) {
        $result = $this->Execute($this->mSqlQueries['insert_notificationtemplate'], $params);
        return $result;
    }

    public function insertNotificationTemplateText($params) {
        $result = $this->Execute($this->mSqlQueries['insert_notificationtemplate_text'], $params);
        return $result;
    }

    public function updateNotificationTemplate($params) {
        return $this->Execute($this->mSqlQueries['update_notificationtemplate'], $params);
    }

    public function deleteNotificationTemplate($id) {
        return $this->Execute($this->mSqlQueries['delete_notificationtemplate'], array($id));
    }

    public function deleteNotificationTemplateText($id) {
        return $this->Execute($this->mSqlQueries['delete_notificationtemplate_text'], array($id));
    }

    public function listNotificationTemplate() {
        return $this->Open($this->mSqlQueries['list_notificationtemplate'], array());
    }

}

// End of file NotificationTemplate.class.php