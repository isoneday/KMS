<?php

/**
 * @author Prima Noor 
 */
class Notification extends Database {

    var $userId;

    function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/comp.notification/business/mysqlt/notification.sql.php');
        $this->userId = Security::Instance()->mAuthentication->GetCurrentUser()->GetUserId();
        $this->SetDebugOn();
    }

    function GetOldNotification() {
        $result = $this->Open($this->mSqlQueries['get_old_notification'], array($this->userId));
        return $result;
    }

    function countNotification() {
        $result = $this->Open('SELECT FOUND_ROWS() AS total', array());
        return $result[0]['total'];
    }

    function getNotification($filter) {
        extract($filter);
        $str = '';
        if (!empty($title)) {
            $str .= " AND LOWER(notif_title) LIKE LOWER('%%$title%%')";
        }
        if (!empty($content)) {
            $str .= " AND LOWER(notif_content) LIKE LOWER('%%$content%%')";
        }
        $query = $this->mSqlQueries['get_notification'];
        $query = str_replace('--filter--', $str, $query);
        $result = $this->Open($query, array(
            $this->userId,
            $start,
            $display));
        return $result;
    }

    function getNewNotification() {
        $result = $this->Open($this->mSqlQueries['get_unread_notification'], array($this->userId));

        if (!empty($result))
            $this->Execute($this->mSqlQueries['set_read'], array($this->userId));

        $this->lastTime = time();
        return $result;
    }

    function getTemplateNotificationDetail($purpose) {
        $lang = $this->Open($this->mSqlQueries['get_default_lang'], array('default_lang'));
        $result = $this->Open($this->mSqlQueries['get_template_notification_detail'], array($purpose, $lang[0]['value']));
        if ($result)
            return $result[0];
    }

    // $userId format: 'id[,id[...]]' atau array('id'[,'id'[,...]])
    function addNotification($title, $content, $userId, $url = '', $duration = 5) {
        if (!is_array($userId))
            $userId = explode(',', $userId);
        if (count($userId) == 1)
            $replacer = '%s';
        else
            $replacer = implode(',', array_fill(0, count($userId), '%s'));
        $sql = $this->mSqlQueries['add_notification_control'];
        $sql = str_replace('--ID-LIST--', $replacer, $sql);

        $this->StartTrans();
        $param = array(
            $title,
            $content,
            $duration,
            $url,
            $this->userId);
        $result = $this->Execute($this->mSqlQueries['add_notification_content'], $param);
        if ($result) 
            $id = $this->LastInsertId();

        $param = array_merge(array($id, $this->userId), $userId);
        if ($result)
            $result = $this->Execute($sql, $param);
        $this->EndTrans($result);

        return $result;
    }

    function addNotificationForBO($title, $content, $url = '', $duration = 5) {
        $groupId = $this->mGroupBO;
        if (count($groupId) == 1)
            $replacer = '%s';
        else
            $replacer = implode(',', array_fill(0, count($groupId), '%s'));
        $sql = $this->mSqlQueries['get_user_id_by_group_id'];
        $sql = str_replace('--ID-LIST--', $replacer, $sql);

        $userId = array();
        $result = $this->Open($sql, $groupId);
        foreach ($result as $value)
            $userId[] = $value['UserId'];

        return $this->DoAddNotificationByUserId($title, $content, $userId, $url, $duration);
    }

}

?>