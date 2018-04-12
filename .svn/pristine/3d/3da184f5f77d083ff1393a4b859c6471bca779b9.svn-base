<?php

class DoFolderOperation extends JsonResponse {

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');
        $msg = array();

        // Data checking
        $_POST = $_POST->AsArray();
        switch (isset($_POST['operation']) ? $_POST['operation'] : '') {
            case "unread":
                $msgOperation = GtfwLangText('set_unread');
                break;
            case "delete":
                $_POST['operation'] = 'move';
                $_POST['ctrlFolderId'] = 4;
            case "unlink":
                $msgOperation = GtfwLangText('deleted');
                break;
            case "move":
                $msgOperation = GtfwLangText('moved');
                break;
            case "email":
                $msgOperation = GtfwLangText('emailed');
                break;
            default:
                $msg[] = GtfwLangText('select_operation');
                $msgOperation = GtfwLangText('processed');
        }

        if (isset($_POST['operation']) && $_POST['operation'] == 'move' && $_POST['folderId'] == $_POST['ctrlFolderId'])
            $msg[] = "Pilih tujuan folder!";
        if (empty($_POST['ctrlId']))
            $msg[] = "Pilih pesan yg ingin $msgOperation!";
        // --------- //

        // Data execution
        $status = 'redo';
        if (empty($msg)) {
            if ($_POST['operation'] == 'email')
                $result = $Obj->sendEmail($_POST);
            else
                $result = $Obj->updateController($_POST);
            $result['msg'] = array(sprintf($result['msg'], $msgOperation));
        } else
            $result = compact('status', 'msg');
        // --------- //

        // Operation completion
        if ($result['status'] == 'redo')
            return array('exec' => "alert(" . json_encode($result['msg']) . ");");
        $from = $_POST['folderId'];
        $to = $_POST['ctrlFolderId'];
        if ($result['status'] == 'fail') {
            Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'folderContent', 'view', 'html', array(
                $_POST,
                $result['msg'],
                'notebox-warning'), Messenger::NextRequest);
            return array('exec' => "$('#msgContainer')[0].folderLoad($from)");
        }
        if ($result['status'] == 'done') {
            Messenger::Instance()->Send(Dispatcher::Instance()->mModule, 'folderContent', 'view', 'html', array(1 => $result['msg'], 'notebox-done'), Messenger::NextRequest);
            if ($_POST['operation'] != 'move')
                return array('exec' => "$('#msgContainer')[0].folderLoad($from)");
            else
                return array('exec' => "var a=$('#msgContainer')[0];a.folderLoad($from);setTimeout(function(){a.folderLoad($to)},500)");
        }
        // --------- //

        return array('exec' => "alert('$result[status]: '+" . json_encode($result['msg']) . ")");
    }
}

?>
