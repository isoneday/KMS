<?php

class ViewSetting extends HtmlResponse {
    
    function TemplateModule() {
        $this->SetTemplateBasedir('module/comp.message/template');
        $this->SetTemplateFile('view_setting.html');
    }

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');

        // Messaging
        $msg = Messenger::Instance()->Receive(__file__);
        $this->Pesan = !empty($msg[0][1])?$msg[0][1]:NULL;
        $this->css = !empty($msg[0][2])?$msg[0][2]:NULL;
        // --------- //

        // Generate data
        $return['focus'] = (isset($_GET['tab']) && $_GET['tab'] == 'settingBlackList') ? 1 : 0;
        $return['folderList'] = $Obj->getFolderList();
        $return['blackList'] = $Obj->GetBlackList();
        $return['userList'] = $Obj->GetAllUser();
        // --------- //

        // Generate url
        $url = array();
        $url['submit'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'saveSetting', 'do', 'json');
        $return['url'] = $url;
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
        $this->mrTemplate->AddVar('content', 'focus', $focus);

        $number = 1;
        foreach ($folderList as $folder) {
            $folder['number'] = $number++;
            $folder['class_name'] = $number % 2 ? 'table-common-even' : '';
            $folder['fldrName_JS'] = addslashes($folder['folder_name']);

            $this->mrTemplate->AddVars('folder_list', $folder);
            $this->mrTemplate->ParseTemplate('folder_list', 'a');
        }

        // Generate UserList
        $userList = array();
        $blackList = array();
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

            $userList[] = $tmp;
        }
        foreach ($data['blackList'] as $value) {
            extract($value);

            $tmp = array();
            $tmp['id'] = $user_id;

            if (empty($user_real_name))
                $user_real_name = $user_user_name;
            elseif ($user_real_name != $user_user_name)
                $user_real_name .= " ($user_user_name)";
            $tmp['complete'] = $user_real_name;
            $tmp['name'] = $user_user_name;

            $blackList[] = $tmp;
        }
        $this->mrTemplate->AddVar('content', 'JSON_UserList', json_encode($userList));
        $this->mrTemplate->AddVar('content', 'JSON_BlackList', json_encode($blackList));
        // --------- //
    }
}

?>
