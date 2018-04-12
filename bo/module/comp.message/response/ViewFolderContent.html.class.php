<?php

class ViewFolderContent extends HtmlResponse {

    function TemplateModule() {
        $template[1] = 'view_folder_inbox.html';
        $template[2] = 'view_folder_sent.html';
        $template[3] = 'view_folder_draft.html';
        $template[4] = 'view_folder_trash.html';
        $template[5] = 'view_folder_custom.html';

        $id = ($this->folderId > 4) ? 5 : $this->folderId;
        $this->SetTemplateBasedir('module/' . Dispatcher::Instance()->mModule . '/template');
        $this->SetTemplateFile($template[$id]);
    }

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');

        // Messaging
        $msg = Messenger::Instance()->Receive(__file__);
        $this->Pesan = !empty($msg[0][1]) ? $msg[0][1] : '';
        $this->css = !empty($msg[0][2]) ? $msg[0][2] : '';
        // --------- //

        // Generate parameter
        if (isset($this->mComponentName))
            $id = (float)substr($this->mComponentName, 7);
        elseif (isset($_REQUEST['folderId']))
            $id = (float)$_REQUEST['folderId']->SqlString()->Raw();
        else
            $id = 0;
        $this->folderId = $id;
        $return['folderId'] = $id;

        if (!isset($this->mComponentName))
            $this->mComponentName = "folder-$id";

        $filter = array();
        $msg = Messenger::Instance()->Receive(__file__, $this->mComponentName);
        $this->Data = !empty($msg[0][0]) ? $msg[0][0] : '';
        if (isset($_POST['cari']))
            foreach ($_POST as $key => $value)
                $filter[$key] = $value->SqlString()->Raw();
            elseif (isset($_GET['page'])) {
                if (isset($this->Data))
                    $filter = $this->Data;
                $filter['page'] = (float)$_GET['page']->SqlString()->Raw();
                $filter['perPage'] = (float)$_GET['display']->SqlString()->Raw();
                if ($filter['page'] < 1)
                    $filter['page'] = 1;
                if ($filter['perPage'] < 1)
                    $filter['perPage'] = 1;
                $filter['start'] = ($filter['page'] - 1) * $filter['perPage'];
            } elseif (isset($_GET['display'])) {
                $filter['page'] = 1;
                $filter['start'] = 0;
                $filter['perPage'] = (float)$_GET['display']->SqlString()->Raw();
            }
        if (!isset($filter['page'])) {
            $filter['page'] = 1;
            $filter['start'] = 0;
            if (!isset($this->Data['perPage'])) {
                $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');
                $filter['perPage'] = (float)$ObjSetting->getValue('view_per_page');
            } else
                $filter['perPage'] = $this->Data['perPage'];
        }
        Messenger::Instance()->SendToComponent(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, $this->mComponentName, array($filter), Messenger::UntilFetched);
        $return['filter'] = $filter;
        // --------- //

        // Generate data
        $return['messageList'] = $Obj->listMessage($id, $filter);

        $total = $Obj->countMessage('get');
        if ($id > 3 && empty($return['messageList'])) {
            $msg = GtfwLangText('no_message');
            if (empty($this->Pesan))
                $this->Pesan = $msg;
            elseif (is_array($this->Pesan))
                $this->Pesan[] = $msg;
            else
                $this->Pesan = array($this->Pesan, $msg);
            if (empty($this->css))
                $this->css = 'notebox-alert';
        }
        $return['newMessageCount'] = $Obj->countNewMessage();
        // --------- //

        // Generate url
        $url = array();
        $url['new'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'newMessage', 'view', 'html');
        $url['detail'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'messageDetail', 'view', 'html');
        $url['folder'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'folderContent', 'view', 'html');
        $url['submit'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'folderOperation', 'do', 'json');
        $return['url'] = $url;
        // --------- //

        // Generate combobox
        $comboFolder = array();
        foreach ($Obj->listFolder() as $folder)
            $comboFolder[] = array('id' => $folder['folder_id'], 'name' => $folder['folder_name']);

        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'ctrlFolderId', array(
            'ctrlFolderId',
            $comboFolder,
            $id,
            null,
            ''), Messenger::CurrentRequest);
        // --------- //

        // Generate paging
        Messenger::Instance()->SendToComponent('comp.paging', 'paging', 'view', 'html', 'paging_top', array(
            $filter['perPage'],
            $total,
            "$url[folder]&folderId=$id",
            $filter['page'],
            "folder-$id"), Messenger::CurrentRequest);
        // --------- //

        return $return;
    }

    function ParseTemplate($data = null) {
        extract($data);

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

        $this->mrTemplate->AddVars('content', $url, 'URL_');
        $this->mrTemplate->AddVar('content', 'FOLDERID', $folderId);

        $number = $filter['start'];
        $messageType = array_flip(array(
            'in',
            'out',
            'draft'));
        if (!empty($messageList)) {
            foreach ($messageList as $message) {
                $number++;
                $message['IS_EMPTY'] = "NO";
                $message['number'] = $number;
                $message['class_name'] = ($number % 2) ? '' : 'table-common-even';
                $message['font_weight'] = ($message['ctrl_is_read'] == 0) ? 'bold' : 'normal';

                $message['SenderName'] = $this->Name($message['SenderUserName'], $message['SenderRealName']);
                if (!empty($message['recipientList']) and count($message['recipientList']) == 1) {
                    $message['RecipientName'] = $this->Name($message['recipientList'][0]['UserName'], $message['recipientList'][0]['user_real_name']);
                } elseif (!empty($message['recipientList']))
                    $message['RecipientName'] = '[Multiple]';

                $message['msgDateModifyLabel'] = $this->Date($message['update_timestamp']);
                if (!empty($message['recipientList']) and $message['recipientList'][0]['ctrl_sent_date'] != '') {
                    $status = ($message['recipientList'][0]['ctrl_read_date'] == '' or $message['recipientList'][0]['ctrl_read_date'] == '1900-01-01 00:00:00') ? 'belum terbaca' : 'terbaca semua';
                    $count = count($message['recipientList']);
                    for ($i = 1; $i < $count; $i++) {
                        $tmp = ($message['recipientList'][$i]['ctrl_read_date'] == '' or $message['recipientList'][$i]['ctrl_read_date'] == '1900-01-01 00:00:00') ? 'belum terbaca' : 'terbaca semua';
                        if ($tmp != $status) {
                            $status = 'terbaca sebagian';
                            break;
                        }
                    }

                    $message['ctrlSentDateLabel'] = $this->Date($message['recipientList'][0]['ctrl_sent_date']);
                    if ($count > 1 or $message['recipientList'][0]['ctrl_read_date'] == '' or $message['recipientList'][0]['ctrl_read_date'] == '1900-01-01 00:00:00')
                        $message['ctrlReadDateLabel'] = $status;
                    else
                        $message['ctrlReadDateLabel'] = $this->Date($message['recipientList'][0]['ctrl_read_date']);
                } else
                    $message['ctrlSentDateLabel'] = 'belum dikirim';

                if ($message['ctrl_is_read'] == '0')
                    $message['url_reply'] = "$url[new]&ctrlId=$message[ctrl_id]";
                else
                    $message['url_reply'] = "$url[new]&inReplyTo=$message[msg_id]";
                $message['url_edit'] = "$url[new]&msgId=$message[msg_id]";
                $message['url_read'] = "$url[detail]&ctrlId=$message[ctrl_id]";
                $message['url_detail'] = "$url[detail]&msgId=$message[msg_id]";

                $message['msgSubject_JS'] = addslashes($message['msg_subject']);

                unset($message['recipientList']);
                unset($messageType[$message['ctrl_type']]);
                $this->mrTemplate->AddVars('message_list_' . $message['ctrl_type'], $message);
                $this->mrTemplate->ParseTemplate('message_list_' . $message['ctrl_type'], 'a');
            }
        }

        foreach (array_keys($messageType) as $type) //if ($this->folderId > 3) $this->mrTemplate->SetAttribute("table_$type", 'visibility', 'hidden');

            $this->mrTemplate->AddVar("message_list_$type", 'IS_EMPTY', 'YES');
        $this->mrTemplate->AddVar('content', 'NEW_MESSAGE_COUNT', $newMessageCount);
    }

    function Date($date) {
        $return = '';
        if ($date !== '0000-00-00 00:00:00') {
            static $days = array(
                'Ahad',
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jum\'at',
                'Sabtu');
            static $months = array(
                1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'Sepetember',
                'Oktober',
                'November',
                'Desember');
            static $currentTime;

            if (!isset($currentTime))
                $currentTime = getdate(time());
            $sentTime = getdate(strtotime($date));
            $divTime = $currentTime[0] - $sentTime[0];
            if ($divTime < 43200 or ($divTime < 86400 and $currentTime['mday'] == $sentTime['mday']))
                $return = date('H:i', $sentTime[0]);
            elseif ($divTime < 432000 or ($divTime < 604800 and date('W', $currentTime[0]) == date('W', $sentTime[0])))
                $return = $days[$sentTime['wday']] . ', ' . date('H:i', $sentTime[0]);
            elseif ($divTime < 15768000 or ($divTime < 31500000 and $currentTime['mon'] == $sentTime['mon']))
                $return = $sentTime['mday'] . ' ' . $months[$sentTime['mon']];
            else
                $return = $sentTime['year'] . ' ' . $months[$sentTime['mon']];
        }
        return $return;
    }

    function Name($UserName, $RealName) {
        if (!empty($RealName) && $RealName != $UserName)
            $return = "$RealName ($UserName)";
        elseif (!empty($UserName))
            $return = $UserName;
        else
            $return = $ServerName;

        return $return;
    }
}

?>
