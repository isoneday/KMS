<?php

class DoNewMessage extends JsonResponse {

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');
        $msg = array();

        // Data checking
        $_POST = $_POST->AsArray();
        
        if (empty($_POST['recipientList']))
            $msg[] = GtfwLangText('select_recipient');
        if (empty($_POST['msg_subject']))
            $msg[] = GtfwLangText('subject_empty');

        if (isset($_POST['isBroadcast'])) {
            $prefix = $Obj->BCprefix;
            if (substr($_POST['msg_subject'], 0, strlen($prefix)) != $prefix)
                $_POST['msg_subject'] = $prefix . $_POST['msg_subject'];
        }

        // Data execution
        $status = 'redo';
        if (!empty($msg))
            $result = compact('status', 'msg');
        else
            $result = $Obj->saveMessage($_POST);

        // Operation completion
        if ($result['status'] == 'redo') {
            Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'newMessage', 'view', 'html', array(
                $_POST,
                $result['msg'],
                'notebox-alert'), Messenger::NextRequest);
            $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'newMessage', 'view', 'html');
            return array('exec' => "replaceContentWithUrl('popup-subcontent','$url&ascomponent=1')");
        }
        if ($result['status'] == 'fail') {
            Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'folderContent', 'view', 'html', array(
                $_POST,
                $result['msg'],
                'notebox-warning'), Messenger::NextRequest);
            return array('exec' => "closeGtPopup(popup_message); $('#msgContainer').tabs('select','folder-3')[0].folderLoad(3)");
        }
        if ($result['status'] == 'done') {
            Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'folderContent', 'view', 'html', array(
                $_POST,
                (isset($_POST['send']) AND $_POST['send'] == 'send') ? GtfwLangText('message_sent') : GtfwLangText('message_saved'),
                'notebox-done'), Messenger::NextRequest);
            $id = (isset($_POST['send']) AND $_POST['send'] == 'send') ? 2 : 3;
            $script = "$('#msgContainer').tabs('select','folder-$id');$('#msgContainer')[0].folderLoad($id);";
            if ($id == 2 && $_POST['msg_id'] != '')
                $script .= "setTimeout(function(){\$('#msgContainer')[0].folderLoad(3)},500)";
            return array('exec' => "closeGtPopup(popup_message);$script");
        }
        // --------- //

        return array('exec' => "alert('$result[status]: $result[msg]')");
    }

}

?>
