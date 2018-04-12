<?php

class ViewNewMessage extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir('module/' . Dispatcher::Instance()->mModule . '/template');
        $this->SetTemplateFile('view_input_message.html');
    }

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');

        // Messaging
        $msg = Messenger::Instance()->Receive(__file__);
        $this->Data = !empty($msg[0][0]) ? $msg[0][0] : null;
        $this->Pesan = !empty($msg[0][1]) ? $msg[0][1] : null;
        $this->css = !empty($msg[0][2]) ? $msg[0][2] : null;

        // Generate data
        $return['broadcast_prefix'] = $Obj->BCprefix;
        if (isset($_GET['ctrlId'])) {
            $_GET['inReplyTo'] = $Obj->readMessage($_GET['ctrlId']->Float()->Raw());
        }
        if (isset($_GET['msgId'])) {
            $return['messageDetail'] = $Obj->getMessageDetail($_GET['msgId']->Float()->Raw());
            if (substr($return['messageDetail']['msg_subject'], 0, strlen($return['broadcast_prefix'])) == $return['broadcast_prefix'])
                $return['messageDetail']['isBroadcast'] = true;
            if ($return['messageDetail']['ctrl_type'] != 'draft')
                $return['messageDetail'] = array();
        } elseif (isset($_GET['inReplyTo'])) {
            $msgDetail = $Obj->getMessageDetail($_GET['inReplyTo']->Float()->Raw());
            if (!empty($msgDetail) && $msgDetail['ctrl_type'] != 'draft') {
                if (empty($msgDetail['msg_in_reply_to']))
                    $msgDetail['msg_in_reply_to'] = $msgDetail['msg_id'];
                $tgl = date('Y/m/d H:i', strtotime($msgDetail['update_timestamp']));
                $msgDetail['msg_content'] = "\n\n\nPada $tgl $msgDetail[SenderUserName] menulis:\n$msgDetail[msg_content]";

                $prefix = "Re: ";
                if (isset($_GET['forward'])) {
                    $prefix = "Fwd: ";
                    $msgDetail['recipientList'] = array();
                    $msgDetail['msg_in_reply_to'] = $msgDetail['msg_id'];
                } else
                    array_unshift($msgDetail['recipientList'], array('user_id' => $msgDetail['msg_owner_id']));

                $subject = $msgDetail['msg_subject'];
                if (substr($subject, 0, strlen($prefix)) != $prefix)
                    $msgDetail['msg_subject'] = "$prefix$subject";

                $msgDetail['msg_id'] = '';
                $return['messageDetail'] = $msgDetail;
            } else
                $return['messageDetail'] = array();
        } elseif (!empty($this->Data))
            $return['messageDetail'] = $this->Data;

        $return['userList'] = $Obj->getUserList();
        $return['satkerList'] = $Obj->getUnitList();
        // --------- //
        // Generate url
        $url = array();
        $url['submit'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'newMessage', 'do', 'json');
        $return['url'] = $url;
        // --------- //

        return $return;
    }

    function ParseTemplate($data = null) {
        if ($this->Pesan) {
            if (is_array($this->Pesan))
                if (count($this->Pesan) > 1) {
                    $tmp = "<ul>";
                    foreach ($this->Pesan as $pesan)
                        $tmp .= "<li>$pesan</li>";
                    $this->Pesan = $tmp;
                } else
                    $this->Pesan = $this->Pesan[0];
            $this->mrTemplate->SetAttribute('warning_box', 'visibility', 'visible');
            $this->mrTemplate->AddVar('warning_box', 'ISI_PESAN', $this->Pesan);
            $this->mrTemplate->AddVar('warning_box', 'CLASS_PESAN', $this->css);
        }

        // Generate satkerIdList
        if (!empty($data['messageDetail'])) //$satkerIdList = $data['messageDetail']['satkerId'];
            unset($data['messageDetail']['satkerId']);
        if (empty($satkerIdList))
            $satkerIdList = array();
        $satkerIdList = array_flip($satkerIdList);
        // --------- //
        // Generate recipientList
        if (!empty($data['messageDetail']['recipientList'])) {
            $recipientList = $data['messageDetail']['recipientList'];
            unset($data['messageDetail']['recipientList']);
            if (!is_array($recipientList))
                foreach (explode(',', $recipientList) as $userId) {
                    $userId = trim($userId);
                    if (!is_array($recipientList))
                        $recipientList = array();
                    $recipientList[$userId] = array();
                }
            else {
                $tmp = $recipientList;
                $recipientList = array();
                foreach ($tmp as $value)
                    $recipientList[$value['user_id']] = array();
            }
        } else
            $recipientList = array();
        // --------- //
        // Generate UserList
        $userList = array();
        $recipients = $recipientList;
        $recipientList = array();
        foreach ($data['userList'] as $value) {
            extract($value);
            
            $tmp = array();
            $tmp['id'] = $user_id;

            if (empty($user_real_name))
                $user_real_name = $user_user_name;
            elseif ($user_real_name != $user_user_name)
                $user_real_name .= " ($user_user_name)";
            $tmp['complete'] = $user_real_name;
            $tmp['name'] = $user_user_name;
            $tmp['group'] = $unit_id;

            $userList[] = $tmp;

            if (isset($recipients[$user_id])) {
                $recipientList[$user_id] = $tmp;
                //$satkerIdList[$satkerId] = $satkerId;
            }
        }
        
        $this->mrTemplate->AddVar('content', 'JSON_UserList', json_encode($userList));
        $this->mrTemplate->AddVar('content', 'JSON_RecipientList', json_encode(array_values($recipientList)));
        // --------- //

        if (!empty($data['messageDetail']))
            foreach (array('msg_subject', 'msg_content') as $key)
                $data['messageDetail'][$key] = htmlentities($data['messageDetail'][$key], ENT_QUOTES);

        if (isset($data['messageDetail']['isBroadcast'])) {
            $data['messageDetail']['broadcast_checked'] = 'checked';
            $data['messageDetail']['broadcast_display'] = '';
        } else
            $data['messageDetail']['broadcast_display'] = 'none';

        $data['messageDetail']['broadcast_prefix'] = addslashes($data['broadcast_prefix']);
        $this->mrTemplate->AddVars('content', $data['messageDetail']);

        $this->mrTemplate->AddVars('content', $data['url'], 'URL_');

        if (!empty($data['satkerList'])) {
            foreach ($data['satkerList'] as $value) {
                $satkerList['id'][] = $value['id'];
                $satkerList['name'][] = $value['name'];

                if (!isset($data['messageDetail']['isBroadcast']))
                    continue;

                if (isset($satkerIdList[$value['id']]))
                    $satkerList['checked'][] = 'checked';
                else
                    $satkerList['checked'][] = '';
            }
            $this->mrTemplate->AddVars('list_satuan_kerja', $satkerList);
        }
    }

}

?>
