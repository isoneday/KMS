<?php

class DoSaveSetting extends JsonResponse {

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');

        $_POST = $_POST->AsArray();
        $url_setting = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'setting', 'view', 'html');
        $url_setting .= ($_POST['operation'] == 'updateBlacklist') ? "&tab=settingBlackList" : "&tab=settingFolder";
        $url_folder = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'folderContent', 'view', 'html');
        $script = "$('#popup-subcontent').load('$url_setting&ascomponent=1')";

        if (in_array($_POST['operation'], array('edit', 'delete')) and $_POST['fldrId'] <= 4) {
            $msg = "Folder tersebut adalah folder sistem.";
            Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'setting', 'view', 'html', array(
                $_POST,
                $msg,
                'notebox-alert'), Messenger::NextRequest);
            return array('exec' => $script);
        }

        switch ($_POST['operation']) {
            case 'add':
                {
                    $result = $Obj->folderAdd($_POST['fldrName']);
                    if ($result) {
                        $msg = GtfwLangText('message_folder_create_success', array($_POST['fldrName']));
                        $_POST['fldrName'] = addslashes($_POST['fldrName']);
                        $script .= ";$('#msgContainer').get(0).folderAdd($result,'$_POST[fldrName]','$url_folder&folderId=$result&ascomponent=1')";
                    } else
                        $msg = GtfwLangText('message_folder_create_fail', array($_POST['fldrName']));

                    Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'setting', 'view', 'html', array(
                        $_POST,
                        $msg,
                        $result ? 'notebox-done' : 'notebox-warning'), Messenger::NextRequest);
                    return array('exec' => $script);
                }
            case 'edit':
                {
                    $result = $Obj->folderEdit($_POST['fldrId'], $_POST['fldrName']);
                    if ($result) {
                        $msg = GtfwLangText('message_folder_rename_success', array($_POST['fldrName']));
                        $_POST['fldrName'] = addslashes($_POST['fldrName']);
                        $script .= ";$('#msgContainer').get(0).folderEdit($_POST[fldrId],'$_POST[fldrName]')";
                    } else
                        $msg = GtfwLangText('message_folder_rename_fail');

                    Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'setting', 'view', 'html', array(
                        $_POST,
                        $msg,
                        $result ? 'notebox-done' : 'notebox-warning'), Messenger::NextRequest);
                    return array('exec' => $script);
                }
            case 'delete':
                {
                    $result = $Obj->folderDelete($_POST['fldrId']);
                    if ($result) {
                        $msg = GtfwLangText('message_folder_delete_success', array($_POST['fldrName']));
                        $_POST['fldrName'] = addslashes($_POST['fldrName']);
                        $script .= ";$('#msgContainer').get(0).folderDelete($_POST[fldrId])";
                    } else
                        $msg = GtfwLangText('folder_delete_fail')." '$_POST[fldrName]'!";

                    Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'setting', 'view', 'html', array(
                        $_POST,
                        $msg,
                        $result ? 'notebox-done' : 'notebox-warning'), Messenger::NextRequest);
                    return array('exec' => $script);
                }
            case 'updateBlacklist':
                {
                    $result = $Obj->updateBlacklist($_POST['blacklistUserId']);
                    if ($result)
                        $msg = GtfwLangText('blaclist_update_success');
                    else
                        $msg = GtfwLangText('blacklist_update_fail');

                    Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'setting', 'view', 'html', array(
                        $_POST,
                        $msg,
                        $result ? 'notebox-done' : 'notebox-warning'), Messenger::NextRequest);
                    return array('exec' => $script);
                }
        }

        return array('exec' => "$script");
    }
}

?>
