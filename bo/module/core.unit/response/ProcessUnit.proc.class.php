<?php

/**
 * @author Prima Noor
 */
class ProcessUnit {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->Obj = GtfwDispt()->load->business('Unit');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('name', GtfwLangText('name'), 'required');

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['parent_id'],
                    $post['code'],
                    $post['name'],
                    $post['description'],
                    $this->user
                );
                $result = $result && $this->Obj->insertUnit($params);
                $this->Obj->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->Obj->StartTrans();
                $params = array(
                    $post['parent_id'],
                    $post['code'],
                    $post['name'],
                    $post['description'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->Obj->updateUnit($params);
                $this->Obj->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_update_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_update_fail');
                    $css = $this->cssFail;
                }
            }
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }
        if ($result) {
            Messenger::Instance()->Send('core.unit', 'unit', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.unit', 'unit', 'view', 'html');
        } else {
            Messenger::Instance()->Send('core.unit', 'inputUnit', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.unit', (empty($post['id'])?'add':'update').'Unit', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = $this->Obj->deleteUnit($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('core.unit', 'unit', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>