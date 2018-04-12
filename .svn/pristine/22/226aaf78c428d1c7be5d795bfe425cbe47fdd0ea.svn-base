<?php

/**
 * @author Prima Noor
 */
class ProcessUser {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->Obj = GtfwDispt()->load->business('User');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();

        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('real_name', GtfwLangText('realname'), 'required');
        $Val->set_rules('name', GtfwLangText('username'), 'required');
        $Val->set_rules('email', GtfwLangText('email'), 'required|valid_email');
        if (empty($post['id'])) {
            $Val->set_rules('confirm_password', GtfwLangText('confirm_password'), '');
            $Val->set_rules('password', GtfwLangText('password'), 'required|matches[confirm_password]');
        }

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['real_name'],
                    $post['name'],
                    $post['email'],
                    $post['password'],
                    $post['desc'],
                    $post['active'],
                    null,
                    $post['active_lang_code'],
                    $this->user
                );
                if ($result)
                    $result = $this->Obj->insertUser($params);
                $userId = $this->Obj->LastInsertId();
                // add user - group
                if ($result AND !empty($post['group'])) {
                    $params = array(
                        $userId,
                        implode(',', $post['group'])
                    );
                    $result = $this->Obj->addUserGroup($params);
                }
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
                    $post['real_name'],
                    $post['name'],
                    $post['email'],
                    $post['desc'],
                    $post['active'],
                    $post['active_lang_code'],
                    $this->user,
                    $post['id']
                );
                if ($result)
                    $result = $this->Obj->updateUser($params);
                $userId = $post['id'];
                // add user - group
                if ($result AND !empty($post['group'])) {
                    $result = $this->Obj->deleteUserGroup($userId);
                    $params = array(
                        $userId,
                        implode(',', $post['group'])
                    );
                    if ($result)
                        $result = $this->Obj->addUserGroup($params);
                }
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
            Messenger::Instance()->Send('core.user', 'user', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.user', 'user', 'view', 'html');
        } else {
            Messenger::Instance()->Send('core.user', 'inputUser', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.user', (empty($post['id'])?'add':'update').'User', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = $this->Obj->deleteUser($id);

        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('core.user', 'user', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

    public function changePassword() {
        $post = $_POST->AsArray();

        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('old_password', GtfwLangText('old_password'), 'required|callback_external_callbacks[ProcessUser, core.user, checkOldPassword]');
        $Val->set_rules('new_password', GtfwLangText('new_password'), 'required');
        $Val->set_rules('conf_password', GtfwLangText('confirm_new_password'), 'required|matches[new_password]');

        $result = $Val->Run();

        if ($result) {
            $params = array(
                $post['new_password'],
                $this->user
            );
            $result = $this->Obj->changePassword($params);
        } else {
            $return['err_msg'] = $Val->error_string('', '<br />');
        }
        $return['status'] = $result;

        return $return;
    }

    public function checkOldPassword($value) {
        $result['message'] = '';
        $result['result'] = false;
        if ($this->Obj->checkOldPassword($value, $this->user)) {
            $result['result'] = true;
        } else {
            $result['message'] = GtfwLangText('custom_validation_wrong_old_password');
        }

        return $result;
    }

}

?>