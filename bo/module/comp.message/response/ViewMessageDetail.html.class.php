<?php

class ViewMessageDetail extends HtmlResponse {
    function TemplateModule() {
        $this->SetTemplateBasedir('module/' . Dispatcher::Instance()->mModule . '/template');
        $this->SetTemplateFile('view_message_detail.html');
    }

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');

        // Messaging
        $msg = Messenger::Instance()->Receive(__file__);
        $this->Data = !empty($msg[0][0]) ? $msg[0][0] : null;
        $this->Pesan = !empty($msg[0][1]) ? $msg[0][1] : null;
        $this->css = !empty($msg[0][2]) ? $msg[0][2] : null;
        // --------- //

        // Generate data
        if (isset($_GET['msgId']))
            $msgId = $_GET['msgId']->Float()->Raw();
        else
            $msgId = $Obj->readMessage($_GET['ctrlId']->Float()->Raw());
        $return['messageDetail'] = $Obj->getMessageDetail($msgId);

        if (empty($return['messageDetail'])) {
            $this->Pesan = "Pesan tidak ditemukan!";
            $this->css = "notebox-alert";
        }
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

        if (isset($data['messageDetail']['recipientList'])) {
            $recipientList = $data['messageDetail']['recipientList'];
            unset($data['messageDetail']['recipientList']);

            foreach ($recipientList as $value) {
                $value['is_empty'] = 'NO';
                $value['Recipient'] = $this->Name($value['UserName'], $value['user_real_name']);
                if ($value['ctrl_read_date'] == '')
                    $value['time'] = 'belum dibaca.';
                else
                    $value['time'] = 'dibaca: ' . $this->Date($value['ctrl_read_date']);

                $this->mrTemplate->AddVars('recipient_list', $value);
                $this->mrTemplate->ParseTemplate('recipient_list', 'a');
            }
        } else
            $this->mrTemplate->AddVar('recipient_list', 'IS_EMPTY', 'YES');

        if (!empty($data['messageDetail'])) {
            $data['messageDetail']['Sender'] = $this->Name($data['messageDetail']['SenderUserName'], $data['messageDetail']['SenderRealName']);
            if (isset($recipientList) and $recipientList[0]['ctrl_sent_date'] != '')
                $data['messageDetail']['time'] = 'dikirim: ' . $this->Date($recipientList[0]['ctrl_sent_date']);
            else
                $data['messageDetail']['time'] = 'belum dikirim.';

            foreach (array('msg_subject', 'msg_content') as $key)
                $data['messageDetail'][$key] = htmlentities($data['messageDetail'][$key]);
            $data['messageDetail']['msg_content'] = nl2br($data['messageDetail']['msg_content']);
            $this->mrTemplate->AddVars('content', $data['messageDetail']);

            switch ($data['messageDetail']['ctrl_type']) {
                case 'in':
                    $url['reply'] = GtfwDispt()->GetUrl('comp.message', 'newMessage', 'view', 'html').'&inReplyTo='.$data['messageDetail']['msg_id'];
                    $url['forward'] = GtfwDispt()->GetUrl('comp.message', 'newMessage', 'view', 'html').'&inReplyTo='.$data['messageDetail']['msg_id'].'&forward';
                    break;
                case 'out':
                    $url['forward'] = GtfwDispt()->GetUrl('comp.message', 'newMessage', 'view', 'html').'&inReplyTo='.$data['messageDetail']['msg_id'].'&forward';
                    break;
                case 'draft':
                    $url['edit'] = GtfwDispt()->GetUrl('comp.message', 'newMessage', 'view', 'html').'&msgId='.$data['messageDetail']['msg_id'];
                    break;
            }
            if (!empty($url)) {
                foreach ($url as $key => $val) {
                    $this->mrTemplate->addVar($key, 'URL', $val);
                }
            }
            
        }
    }

    function Name($UserName, $RealName) {
        if (empty($RealName))
            $return = $UserName;
        elseif ($RealName != $UserName)
            $return = "$RealName ($UserName)";
        else
            $return = $UserName;

        return $return;
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

            $date = getdate(strtotime($date));
            $return = $days[$date['wday']] . ', ' . $date['mday'] . ' ' . $months[$date['mon']] . ' ' . $date['year'] . ', ' . date('H:i:s', $date[0]);
        }
        return $return;
    }
}

?>
