<?php

/**
 * @author Prima Noor
 */
class ProcessEmployeeUser {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->Obj = GtfwDispt()->load->business('EmployeeUser');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('real_name', GtfwLangText('realname'), 'required');
        $Val->set_rules('name', GtfwLangText('username'), 'required');
        $Val->set_rules('email', GtfwLangText('email'), 'required|valid_email');
        if (!empty($post['emp_id'])) {
            $Val->set_rules('confirm_password', GtfwLangText('confirm_password'), '');
            $Val->set_rules('password', GtfwLangText('password'), 'required|matches[confirm_password]');
        }

        $result = $Val->run();
        if ($result) {
            if ($post['emp_id']) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['real_name'],
                    $post['name'],
                    $post['email'],
                    $post['password'],
                    $post['desc'],
                    $post['status'],
                    0,
                    $post['active_lang_code'],
                    $this->user
                );
                if ($result) {
                    $result = $this->Obj->insertUser($params);
                    $userId = $this->Obj->LastInsertId();

                    // add emp employee user
                    if ($result AND !empty($post['emp_id'])) {
                        $params = array(
                            $post['emp_id'],
                            $userId,
                            $post['desc'],
                            $this->user
                        );
                        $result = $this->Obj->insertEmployeeUser($params);

                        // add user - group
                        if ($result AND !empty($post['group'])) {
                            $params = array(
                                $userId,
                                implode(',', $post['group'])
                            );
                            $result = $this->Obj->addUserGroup($params);
                        }
                    }
                }

                $this->Obj->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            }
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }
        if ($result) {
            Messenger::Instance()->Send('emp.employee.mini', 'EmployeeMini', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        } else {
            Messenger::Instance()->Send('emp.employee.mini', 'inputEmployeeUser', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
        }
        return $result;
    }

    function update() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('real_name', GtfwLangText('realname'), 'required');
        $Val->set_rules('name', GtfwLangText('username'), 'required');
        $Val->set_rules('email', GtfwLangText('email'), 'required|valid_email');

        $result = $Val->run();
        if ($result) {
            if ($post['id']) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['real_name'],
                    $post['name'],
                    $post['email'],
                    $post['desc'],
                    $post['status'],
                    $post['active_lang_code'],
                    $this->user,
                    $post['id']
                );
                if ($result)
                    $result = $this->Obj->updateUser($params);
                $userId = $post['id'];

                // add emp employee user
                if ($result AND !empty($post['emp_id'])) {
                    $params = array(
                        $userId,
                        $post['desc'],
                        $this->user,
                        $post['emp_id']
                    );
                    $result = $result && $this->Obj->updateEmployeeUser($params);

                    // add user - group
                    if ($result AND !empty($post['group'])) {
                        $result = $this->Obj->deleteUserGroup($userId);
                        $params = array(
                            $userId,
                            implode(',', $post['group'])
                        );
                        if ($result)
                            $result = $result && $this->Obj->addUserGroup($params);
                    }
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
            Messenger::Instance()->Send('emp.employee.mini', 'EmployeeMini', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        } else {
            Messenger::Instance()->Send('emp.employee.mini', 'editEmployeeUser', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
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
        Messenger::Instance()->Send('emp.employee', 'Employee', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

    function randomChar($length) {
        $char = 'ABCDEFGHIJKL1234567890';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = rand(0, strlen($char) - 1);
            $string .= $char{$pos};
        }
        return $string;
    }

    function resetPassword($id) {
        $result = true;
        $this->Obj->StartTrans();
        $user = $this->Obj->getUserData($id);
        //$pass = $this->randomChar(5);
        $pass = $user['user_name'];
        $params = array(
            $pass,
            $this->user,
            $user['user_id']
        );

        $result = $this->Obj->resetPassword($params);
        $this->Obj->EndTrans($result);
        if ($result) {
            $msg = GtfwLangText('reset_password_success') . "<br/>";
            $msg .= "<pre><b>" . GtfwLangText('detail_account') . "</b><br/>";
            $msg .= GtfwLangText('username') . " : " . $user['user_name'] . "<br/>";
            $msg .= GtfwLangText('password') . " : " . $user['user_name'] . "</pre>";

            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('reset_password_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('emp.employee.mini', 'EmployeeMini', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>