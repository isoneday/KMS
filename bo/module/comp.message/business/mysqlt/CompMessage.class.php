<?php

/**
 * @author Prima Noor 
 */
class CompMessage extends Database {

    var $userId;
    var $unitId;
    var $userName;
    var $BCprefix = '[Broadcast] ';

    function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/comp.message/business/mysqlt/compmessage.sql.php');

        $this->userId = Security::Instance()->mAuthentication->GetCurrentUser()->GetUserId();
        $this->userName = Security::Instance()->mAuthentication->GetCurrentUser()->GetUserName();

        $this->SetDebugOn();
    }

    public function listFolder() {
        $result = $this->Open($this->mSqlQueries['list_folder'], array($this->userId));
        return $result;
    }

    public function listMessage($folderId, $filter) {
        extract($filter);
        $ServerName = $this->GetServerName();

        $result = $this->Open($this->mSqlQueries['list_message'], array(
            $folderId,
            $this->userId,
            (float) $start,
            (int) $perPage));

        $return = array();
        $msgIdList = array();
        $tmp = array();
        foreach ($result as $value) {
            if (empty($value['SenderUserName']))
                $value['SenderUserName'] = $ServerName;
            $tmp[$value['ctrl_type']][$value['msg_id']] = $value;
            $msgIdList[] = $value['msg_id'];
        }
        $this->countMessage('set');

        if (isset($tmp['in']))
            $return += $tmp['in'];
        if (isset($tmp['out']))
            $return += $tmp['out'];
        if (isset($tmp['draft']))
            $return += $tmp['draft'];

        if (!empty($msgIdList)) {
            $count = count($msgIdList);
            if ($count > 1) {
                $param = implode(',', array_fill(0, $count, "'%s'"));
                $sql = str_replace("'%s'", $param, $this->mSqlQueries['get_recipient_list']);
            } else
                $sql = $this->mSqlQueries['get_recipient_list'];

            $result = $this->Open($sql, $msgIdList);
            foreach ($result as $value)
                $return[$value['msgId']]['recipientList'][] = $value;
        }

        return $return;
    }

    function countMessage($mode = '') {
        static $count;

        $result = $this->Open("SELECT FOUND_ROWS() AS total", array());
        $return = $result[0]['total'];

        if ($mode == 'get') {
            $return = $count;
            $count = null;
        } elseif ($mode == 'set')
            $count = $return;

        return $return;
    }

    function countNewMessage() {
        $result = $this->Open($this->mSqlQueries['count_new_message'], array($this->userId));
        return $result[0]['total'];
    }

    function readMessage($ctrlId) {
        $result = $this->Open($this->mSqlQueries['get_message_to_read'], array($ctrlId, $this->userId));

        if (empty($result))
            return 0;

        $msgId = $result[0]['ctrl_msg_id'];
        if ($result[0]['ctrl_is_read'] == 0)
            $this->Execute($this->mSqlQueries['control_set_read'], array($ctrlId));

        return $msgId;
    }

    function getMessageDetail($msgId) {
        $result = $this->Open($this->mSqlQueries['get_message_detail'], array($msgId, $this->userId));
        if (empty($result))
            return array();
        $return = $result[0];

        $result = $this->Open($this->mSqlQueries['get_recipient_list'], array($msgId));
        foreach ($result as $value)
            $return['recipientList'][] = $value;

        if (empty($return['SenderUserName']))
            $return['SenderUserName'] = $this->GetServerName();
        return $return;
    }

    function getUserList() {
        $result = $this->Open($this->mSqlQueries['get_user_list'], array($this->userId));
        return $result;
    }

    // Required data: recipientList, msgSubject, msgContent
    // Example: $data['recipientList'] = '1,2,3'; <~ userId list
    //          $data['msgSubject'] = 'Subject of message';
    //          $data['msgContent'] = 'Content of message';
    function saveMessage($data) {
        extract($data);
        $isSuccess = true;
        $msg = array();
        // flip (swap array key x value), untuk mencegah duplikasi recipient, nanti tinggal diambil array_key nya
        $recipientList = array_flip(explode(',', $recipientList));

        $this->StartTrans();

        if (!empty($msg_id)) {
            $msgId = $msg_id;
            $result = $this->Open($this->mSqlQueries['get_recipient_list'], array($msg_id));
            
            $recipientDelete = array();
            foreach ($result as $value)
                if (isset($recipientList[$value['user_id']]))
                    unset($recipientList[$value['user_id']]);
                else
                    $recipientDelete[] = $value['ctrlId'];
            if (!empty($recipientDelete)) {
                $count = count($recipientDelete);
                if ($count > 1) {
                    $param = implode(',', array_fill(0, $count, "'%s'"));
                    $sql = str_replace("'%s'", $param, $this->mSqlQueries['control_delete_recipient']);
                } else
                    $sql = $this->mSqlQueries['control_delete_recipient'];

                $isSuccess = $this->Execute($sql, $recipientDelete);
                
                if (!$isSuccess)
                    $msg[] = GtfwLangText('delete_recipient_fail');
            }
        } else {
            $msgId = null;
        }
        if (empty($msg_in_reply_to))
            $msg_in_reply_to = null;
        $recipientList = array_keys($recipientList);

        if ($isSuccess)
            $isSuccess = $this->Execute($this->mSqlQueries['save_message_content'], array(
                $msg_id,
                $msg_subject,
                $msg_content,
                $msg_in_reply_to,
                $this->userId));
        
        if (!$isSuccess)
            $msg[] = GtfwLangText('save_message_content_fail');
        elseif (empty($msgId)) {
            $msgId = $this->LastInsertId();
            $isSuccess = $this->Execute($this->mSqlQueries['control_add_sender'], array($msgId, $this->userId));
            
            if (!$isSuccess)
                $msg[] = GtfwLangText('save_recipient_fail');
        }

        if ($isSuccess && !empty($recipientList)) {
            $sql = $this->mSqlQueries['control_add_recipient'];
            $sql = str_replace("--IDLIST--", implode(',', array_fill(0, count($recipientList), "'%s'")), $sql);

            $param = $recipientList;
            array_unshift($param, $msgId);
            $isSuccess = $this->Execute($sql, $param);
            
            if (!$isSuccess)
                $msg[] = GtfwLangText('save_recipient_fail');
        }

        if ($isSuccess && isset($send) && $send == 'send') {
            $isSuccess = $this->Execute($this->mSqlQueries['control_send'], array($msgId));
            
            if ($isSuccess) {
                // adding notification
                $recipientList = array();
                $result = $this->Open($this->mSqlQueries['get_recipient_list'], array($msgId));
                
                foreach ($result as $value)
                    $recipientList[] = $value['user_id'];
                $url = 'comp.message|msgContainer|view|html';

                $Notif = GtfwDispt()->load->business('Notification', 'comp.notification');
                $a = $Notif->addNotification(GtfwLangText('new_message'), GtfwLangText('new_message_notification', array($this->userName, $msg_subject)), $recipientList, $url);
                // --------- //
            } else
                $msg[] = GtfwLangText('message_send_fail');
        }
        
        $this->EndTrans($isSuccess);
        

        if ($isSuccess)
            $status = 'done';
        else
            $status = 'fail';

        return compact('status', 'msg');
    }

    function sendEmail($data) {
        extract($data);
        $ObjMail = GtfwDispt()->load->library('PHPMailer');

        $count = count($ctrlId);
        if ($count > 1) {
            $tmp = implode(',', array_fill(0, $count, "'%s'"));
            $sql = str_replace("'%s'", $tmp, $this->mSqlQueries['get_message_detail_for_email']);
        } else
            $sql = $this->mSqlQueries['get_message_detail_for_email'];

        $param = $ctrlId;
        $param[] = $this->userId;
        $result = $this->Open($sql, $param);

        $i = 0;
        $ObjMail = GtfwDispt()->load->library('PHPMailer');

        //$ObjMail->SMTPDebug = 2; // enables SMTP debug information (for testing)
        ob_start();
        foreach ($result as $Msg) {
            if (empty($Msg['receiverEmail']))
                return array('status' => 'fail', 'msg' => 'User anda belum diatur alamat emailnya!');
            if (empty($Msg['senderEmail']))
                $Msg['senderEmail'] = 'no_reply@unknown.com';
            if (empty($Msg['senderName']))
                $Msg['senderName'] = $this->getServerName();
            $Msg['receiverName'] = ucwords(strtolower($Msg['receiverName']));
            $Msg['senderName'] = ucwords(strtolower($Msg['senderName']));

            $ObjMail->SetFrom($Msg['senderEmail'], $Msg['senderName']);
            $ObjMail->AddAddress($Msg['receiverEmail'], $Msg['receiverName']);

            $ObjMail->Subject = $Msg['msg_subject'];
            $ObjMail->Body = $Msg['msg_content'];

            if (!$ObjMail->Send()) {
                break;
            }
            $i++;
        }
        ob_end_clean();

        return array('status' => 'done', 'msg' => "$i pesan berhasil %s!");
    }

    function getServerName() {
        static $ServerName;

        if (!isset($ServerName)) {
            $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');
            $ServerName = $ObjSetting->getValue('username_server_message');
            if (empty($ServerName))
                $ServerName = 'SYSTEM';
        }

        return $ServerName;
    }

    function updateController($data) {
        extract($data);

        $replacer = implode(',', array_fill(0, count($ctrlId), '%s'));
        $sql = $this->mSqlQueries["control_$operation"];
        $sql = str_replace('(%s)', "($replacer)", $sql);

        $param = $ctrlId;
        $param[] = $this->userId;
        if ($operation == 'move')
            array_unshift($param, $ctrlFolderId);

        if ($this->Execute($sql, $param)) {
            $return['msg'] = $this->Affected_Rows() . ' ' . GtfwLangText('message_successfully') . ' %s!';
            $return['status'] = 'done';
        } else {
            $return['msg'] = 'Pesan gagal %s!<span style="display: none">' . mysql_error() . '</span>';
            $return['status'] = 'fail';
        }

        return $return;
    }

    public function getFolderList() {
        $result = $this->Open($this->mSqlQueries['get_folder_list'], array($this->userId));
        return $result;
    }

    function getAllUser() {
        $result = $this->Open($this->mSqlQueries['get_all_user'], array($this->userId));
        return $result;
    }

    function getBlackList() {
        $result = $this->Open($this->mSqlQueries['get_black_list'], array($this->userId));
        return $result;
    }

    function folderAdd($name) {
        $result = $this->Execute($this->mSqlQueries['folder_add'], array($name, $this->userId));
        if (!$result)
            return false;
        return $this->LastInsertId();
    }

    function folderEdit($id, $name) {
        return $this->Execute($this->mSqlQueries['folder_edit'], array(
                    $name,
                    $id,
                    $this->userId));
    }

    function folderDelete($id) {
        $this->StartTrans();
        $result = $this->Execute($this->mSqlQueries['folder_unlink'], array($id, $this->userId));
        if ($result)
            $result = $this->Execute($this->mSqlQueries['folder_delete'], array($id, $this->userId));
        $this->EndTrans($result);
        return $result;
    }

    function updateBlacklist($list) {
        if (empty($list))
            $new = array();
        else
            $new = array_flip(explode(',', $list));
        $old = array();
        foreach ($this->GetBlackList() as $value)
            $old[$value['user_id']] = $value['user_id'];

        foreach (array_keys($new) as $id)
            if (!isset($old[$id]))
                $add[] = $id;
            else
                unset($new[$id], $old[$id]);
        foreach (array_keys($old) as $id)
            if (!isset($new[$id]))
                $del[] = $id;
        if (isset($add))
            $op[] = 'add';
        if (isset($del))
            $op[] = 'del';

        $this->StartTrans();
        $result = true;
        if (isset($op))
            foreach ($op as $op) {
                $replacer = implode(',', array_fill(0, count($$op), '%s'));
                $sql = $this->mSqlQueries["blacklist_$op"];
                $sql = str_replace('(%s)', "($replacer)", $sql);

                $param = $$op;
                $param[] = $this->userId;

                if ($result)
                    $result = $this->Execute($sql, $param);
            }
        $this->EndTrans($result);
        return $result;
    }

    public function getUnitList() {
        return $this->Open($this->mSqlQueries['get_unit_list'], array());
    }

}

?>