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
          $config = array('dest' => Configuration::Instance()->GetValue('application', 'aplikan_photo'), //direktori to upload file
            'ext' => 'jpg,png,jpeg,gif,PNG', //white list extension file, optional. default : ico,gif
            "maxsize" => 2097152 // maksimum file to upload. this optional. default : value in php.ini.
        );
        //to call upload library and initialize config 
        $ObjUpload = GtfwDispt()->load->library('Upload', $config);

        $Val->set_rules('personal_id', GtfwLangText('personal_id'), 'required');
        $Val->set_rules('jenis_kelamin', GtfwLangText('jenis_kelamin'), 'required');
        $Val->set_rules('agama', GtfwLangText('agama'), 'required');
        $Val->set_rules('posisi_kerja', GtfwLangText('posisi_kerja'), 'required');
        $Val->set_rules('tahun_masuk', GtfwLangText('tahun_masuk'), 'required');
        $Val->set_rules('kode_pos', GtfwLangText('kode_pos'), 'required');
        $Val->set_rules('tempat_lahir', GtfwLangText('tempat_lahir'), 'required');
        $Val->set_rules('alamat', GtfwLangText('alamat'), 'required');
        $Val->set_rules('no_hp', GtfwLangText('no_hp'), 'required');
        $Val->set_rules('real_name', GtfwLangText('realname'), 'required');
        $Val->set_rules('name', GtfwLangText('username'), 'required');
        $Val->set_rules('email', GtfwLangText('email'), 'required|valid_email');
    //    $Val->set_rules('emp_type_id', GtfwLangText('employee_type'), 'required');

        if (empty($post['id'])) {
            $Val->set_rules('confirm_password', GtfwLangText('confirm_password'), '');
            $Val->set_rules('password', GtfwLangText('password'), 'required|matches[confirm_password]');
        }

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['personal_id'], 
                    $post['jenis_kelamin'],
                    $post['agama'],
                    $post['posisi_kerja'],
                    $post['tahun_masuk'],
                    $post['kode_pos'],
                    $post['tempat_lahir'],
                    $post['alamat'],
                    $post['no_hp'],
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
                  $result = $this->Obj->insertUser($params);
                 $userId = $this->Obj->LastInsertId();
                // if ($result) {
                //     $result = $result && $this->addEmployeeType($emp_id, $post);
                // }
                     if ($result) {
                    $upload = $ObjUpload->DoUpload();
                    if (!empty($upload['photo'])) {
                        //function to upload file
                        //$upload = $ObjUpload->DoUpload();
                        if (empty($upload['photo']['error'])) {
                            //get data to insert database
                            $name_enc = $upload['photo']['name_enc'];
                            $name_ori = $upload['photo']['name_ori'];
                            $file_path = $upload['photo']['file_path'];
                            $file_ext = $upload['photo']['file_ext'];
                            $file_size = $upload['photo']['file_size'];

                            $params = array(
                                $userId,
                                '1',
                                $name_ori,
                                $name_enc,
                                $file_path.$name_enc,
                                $file_ext,
                                $file_size,
                                $this->user
                            );
                            $photo_result =$this->Obj->insertFilePhoto($params);
                        }
                    }
                }
               
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
                       $post['personal_id'],
                       $post['id_photo'],
                       
                    $post['jenis_kelamin'],
                    $post['agama'],
                    $post['posisi_kerja'],
                    $post['tahun_masuk'],
                    $post['kode_pos'],
                    $post['tempat_lahir'],
                    $post['alamat'],
                    $post['no_hp'],
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
                 if ($result) {
                    //function to upload file
                    $upload = $ObjUpload->DoUpload();
                    if (!empty($upload['photo'])) {
                        if (empty($upload['photo']['error'])) {
                            @unlink(Configuration::Instance()->GetValue('application', 'aplikan_photo') . $post['photo_path']);
                            //get data to insert database
                            $name_enc = $upload['photo']['name_enc'];
                            $name_ori = $upload['photo']['name_ori'];
                            $file_path = $upload['photo']['file_path'];
                            $file_ext = $upload['photo']['file_ext'];
                            $file_size = $upload['photo']['file_size'];

                            if (!empty($post['id_photo'])) {
                                $params = array(
                                    '1',
                                      $name_ori,
                                    $name_enc,
                                    $file_path.$name_enc,
                                    $file_ext,
                                    $file_size,
                                    $this->user,
                                    $post['id_photo']
                                );
                                $photo_result = $result && $this->Obj->updateFilePhoto($params);
                            } else {
                                $params = array(
                                    '1',
                                    $name_ori,
                                    $name_enc,
                                    $file_path.$name_enc,
                                    $file_ext,
                                    $file_size,
                                    '3' 
                                );
                                $photo_result = $result && $this->Obj->updateFilePhoto($params);
                            }
                        }
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