<?php

/**
 * @author Prima Noor
 */
class ProcessCoreUserall {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjCoreUserall = GtfwDispt()->load->business('CoreUserall');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('real_name', GtfwLangText('real_name'), 'required');
        $Val->set_rules('name', GtfwLangText('username'), 'required');
        $Val->set_rules('email', GtfwLangText('email'), 'required|valid_email');
        if (empty($post['id'])) {
            $Val->set_rules('confirm_password', GtfwLangText('confirm_password'), '');
            $Val->set_rules('password', GtfwLangText('password'), 'required|matches[confirm_password]');
        }
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjCoreUserall->StartTrans();
                $params = array(
                    $post['real_name'],
                    $post['name'],
                    $post['email'],
                    $post['password'],
                    $post['desc'],
                    $post['active'],
                    $post['active_lang_code'],
                    $this->user
                );
                $result = $result && $this->ObjCoreUserall->insertCoreUserall($params);
                $userId = $this->ObjCoreUserall->LastInsertId();
                // add user - group
                if ($result && !empty($post['group'])) {
                    $params = array(
                        $userId,
                        implode(',', $post['group'])
                    );
                    $result = $this->ObjCoreUserall->addUserGroup($params);
                }
                $this->ObjCoreUserall->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjCoreUserall->StartTrans();
                $params = array(
                    $post['real_name'],
                    $post['name'],
                    $post['email'],
                    $post['desc'],
                    $post['active'],
                    $post['active_lang_code'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjCoreUserall->updateCoreUserall($params);
                $userId = $post['id'];
                // add user - group
                if ($result && !empty($post['group'])) {
                    $result = $this->ObjCoreUserall->deleteUserGroup($userId);
                    $params = array(
                        $userId,
                        implode(',', $post['group'])
                    );
                    if ($result)
                        $result = $this->ObjCoreUserall->addUserGroup($params);
                }
                $this->ObjCoreUserall->EndTrans($result);
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
            Messenger::Instance()->Send('core.userall', 'CoreUserall', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.userall', 'coreuserall', 'view', 'html');
        } else {
            Messenger::Instance()->Send('core.userall', 'inputCoreUserall', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.userall', (empty($post['id'])?'add':'update').'CoreUserall', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = true;
        $this->ObjCoreUserall->StartTrans();
        $result = $this->ObjCoreUserall->deleteUserGroup($id);
        $result = $result && $this->ObjCoreUserall->deleteCoreUserall($id);
        $this->ObjCoreUserall->EndTrans($result);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('core.userall', 'CoreUserall', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>