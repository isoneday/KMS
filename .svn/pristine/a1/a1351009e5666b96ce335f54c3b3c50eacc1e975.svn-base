<?php

/**
 * @author Prima Noor
 */
class ProcessEmployeeMini {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjEmployeeMini = GtfwDispt()->load->business('EmployeeMini');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        ////initialize for gtupload check server side. this configuration can be optional
        $config = array('dest' => Configuration::Instance()->GetValue('application', 'employee_save_path'), //direktori to upload file
            'ext' => 'jpg,png,jpeg,gif,PNG', //white list extension file, optional. default : ico,gif
            "maxsize" => 2097152 // maksimum file to upload. this optional. default : value in php.ini.
        );
        //to call upload library and initialize config 
        $ObjUpload = GtfwDispt()->load->library('Upload', $config);

        $Val->set_rules('full_name', GtfwLangText('full_name'), 'required');
        $Val->set_rules('salutation_id', GtfwLangText('salutation_id'), 'required');
        $Val->set_rules('gender', GtfwLangText('gender'), 'required');
        $Val->set_rules('email', GtfwLangText('email'), 'required');

        $Val->set_rules('emp_status_id', GtfwLangText('employee_status'), 'required');
        $Val->set_rules('emp_unit_id', GtfwLangText('employee_work_unit'), 'required');
        $Val->set_rules('emp_position_id', GtfwLangText('employee_structural_position'), 'required');
        $Val->set_rules('emp_type_id', GtfwLangText('employee_type'), 'required');

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjEmployeeMini->StartTrans();
                $params = array(
                    $post['parent_number'],
                    null, //$post['system_code'],
                    null, //$post['access_code'],
                    $post['full_name'],
                    null, //$post['first_name'],
                    null, //$post['middle_name'],
                    null, //$post['last_name'],
                    $post['nick_name'],
                    null, //$post['official_name'],
                    $post['salutation_id'],
                    null, //$post['title_prefix'],
                    null, //$post['title_sufix'],
                    null, //$post['birth_place'],
                    null, //$ost['birth_date'],
                    $post['gender'],
                    null, //$post['religion_id'],
                    null, //$post['belief'],
                    'local', //$post['nationality_status'],
                    null, //$post['country_id'],
                    null, //$post['ethnic'],
                    null, //$post['dialect'],
                    null, //$post['bloodtype_id'],
                    null, //$post['weight'],
                    null, //$post['height'],
                    null, //$post['head_size'],
                    null, //$post['clothes_size'],
                    null, //$post['pants_size'],
                    null, //$post['shoe_size'],
                    null, //$post['skin_color'],
                    null, //$post['hair_color'],
                    null, //$post['face_shape'],
                    null, //$post['typical'],
                    null, //$post['disabilitytype_id'],
                    null, //$post['disability'],
                    null, //$post['disease'],
                    null, //$post['alergy'],
                    null, //$post['medical_check_status'],
                    null, //$post['medical_check_reason'],
                    null, //$post['hobby'],
                    null, //$post['pension_age'],
                    null, //$post['strength'],
                    null, //$post['weakness'],
                    null, //$post['spare_time'],
                    null, //$post['reasons_to_join'],
                    null, //$post['is_applicant'],
                    null, //$post['workpertype_id'],
                    null, //$post['train_date'],
                    null, //$post['join_date'],
                    null, //$post['quit_date'],
                    null, //$post['employtype_id'],
                    null, //$post['workhour_id'],
                    null, //$post['npwp_status'],
                    null, //$post['jms_status'],
                    null, //$post['healthins_status'],
                    null, //$post['intins_status'],
                    null, //$post['extins_status'],
                    null, //$post['is_vendor'],
                    null, //$post['is_customer'],
                    1, //$post['status'],
                    null, //$post['desc'],
                    null, //$post['empstat_id'],
                    1, //$post['is_locked'],
                    $this->user
                );
                $result = $result && $this->ObjEmployeeMini->insertEmployeeMini($params);
                $emp_id = $this->ObjEmployeeMini->LastInsertId();
                #insert ke table turunan
                if ($result) {
                    $result = $this->addEmployeeEmail($emp_id, $post);
                    $result = $result && $this->addEmployeeStatus($emp_id, $post);
                    $result = $result && $this->addEmployeeUnit($emp_id, $post);
                    $result = $result && $this->addEmployeeStruct($emp_id, $post);
                    $result = $result && $this->addEmployeeType($emp_id, $post);
                }
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
                                $emp_id,
                                '1',
                                $name_ori,
                                $name_ori,
                                $name_enc,
                                $file_ext,
                                $file_size,
                                $this->user
                            );
                            $photo_result = $result && $this->ObjEmployeeMini->insertFilePhoto($params);
                        }
                    }
                }
                $this->ObjEmployeeMini->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjEmployeeMini->StartTrans();
                $params = array(
                    $post['parent_number'],
                    null, //$post['system_code'],
                    null, //$post['access_code'],
                    $post['full_name'],
                    null, //$post['first_name'],
                    null, //$post['middle_name'],
                    null, //$post['last_name'],
                    $post['nick_name'],
                    null, //$post['official_name'],
                    $post['salutation_id'],
                    null, //$post['title_prefix'],
                    null, //$post['title_sufix'],
                    null, //$post['birth_place'],
                    null, //$ost['birth_date'],
                    $post['gender'],
                    null, //$post['religion_id'],
                    null, //$post['belief'],
                    'local', //$post['nationality_status'],
                    null, //$post['country_id'],
                    null, //$post['ethnic'],
                    null, //$post['dialect'],
                    null, //$post['bloodtype_id'],
                    null, //$post['weight'],
                    null, //$post['height'],
                    null, //$post['head_size'],
                    null, //$post['clothes_size'],
                    null, //$post['pants_size'],
                    null, //$post['shoe_size'],
                    null, //$post['skin_color'],
                    null, //$post['hair_color'],
                    null, //$post['face_shape'],
                    null, //$post['typical'],
                    null, //$post['disabilitytype_id'],
                    null, //$post['disability'],
                    null, //$post['disease'],
                    null, //$post['alergy'],
                    null, //$post['medical_check_status'],
                    null, //$post['medical_check_reason'],
                    null, //$post['hobby'],
                    null, //$post['pension_age'],
                    null, //$post['strength'],
                    null, //$post['weakness'],
                    null, //$post['spare_time'],
                    null, //$post['reasons_to_join'],
                    null, //$post['is_applicant'],
                    null, //$post['workpertype_id'],
                    null, //$post['train_date'],
                    null, //$post['join_date'],
                    null, //$post['quit_date'],
                    null, //$post['employtype_id'],
                    null, //$post['workhour_id'],
                    null, //$post['npwp_status'],
                    null, //$post['jms_status'],
                    null, //$post['healthins_status'],
                    null, //$post['intins_status'],
                    null, //$post['extins_status'],
                    null, //$post['is_vendor'],
                    null, //$post['is_customer'],
                    1, //$post['status'],
                    null, //$post['desc'],
                    null, //$post['empstat_id'],
                    1, //$post['is_locked'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjEmployeeMini->updateEmployeeMini($params);
                #insert ke table turunan
                if ($result) {
                    $result = $this->updateEmployeeEmail($post['id'], $post);
                    $result = $result && $this->updateEmployeeStatus($post['id'], $post);
                    $result = $result && $this->updateEmployeeUnit($post['id'], $post);
                    $result = $result && $this->updateEmployeeStruct($post['id'], $post);
                    $result = $result && $this->updateEmployeeType($post['id'], $post);
                }
                if ($result) {
                    //function to upload file
                    $upload = $ObjUpload->DoUpload();
                    if (!empty($upload['photo'])) {
                        if (empty($upload['photo']['error'])) {
                            @unlink(Configuration::Instance()->GetValue('application', 'employee_save_path') . $post['photo_path']);
                            //get data to insert database
                            $name_enc = $upload['photo']['name_enc'];
                            $name_ori = $upload['photo']['name_ori'];
                            $file_path = $upload['photo']['file_path'];
                            $file_ext = $upload['photo']['file_ext'];
                            $file_size = $upload['photo']['file_size'];

                            if (!empty($post['photo_id'])) {
                                $params = array(
                                    '1',
                                    $name_ori,
                                    $name_ori,
                                    $name_enc,
                                    $file_ext,
                                    $file_size,
                                    $this->user,
                                    $post['photo_id']
                                );
                                $photo_result = $result && $this->ObjEmployeeMini->updateFilePhoto($params);
                            } else {
                                $params = array(
                                    $post['id'],
                                    '1',
                                    $name_ori,
                                    $name_ori,
                                    $name_enc,
                                    $file_ext,
                                    $file_size,
                                    $this->user
                                );
                                $photo_result = $result && $this->ObjEmployeeMini->insertFilePhoto($params);
                            }
                        }
                    }
                }
                $this->ObjEmployeeMini->EndTrans($result);
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
            Messenger::Instance()->Send('emp.employee.mini', 'inputEmployeeMini', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
        }
        return $result;
    }

    function addEmployeeEmail($id, $post) {
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $id,
            '5',
            $post['email'],
            1,
            $this->user
        );
        $result = $this->ObjEmployeeMini->insertEmpEmail($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function updateEmployeeEmail($id, $post) {
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            '5',
            $post['email'],
            1,
            $this->user,
            $id
        );
        $result = $this->ObjEmployeeMini->updateEmpEmail($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function addEmployeeStatus($id, $post) {
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $id,
            $post['emp_status_id'],
            date("Y-m-d"),
            '9999-12-31',
            '',
            '',
            NULL,
            '',
            '',
            '1',
            1,
            0,
            1,
            $this->user
        );
        $result = $this->ObjEmployeeMini->insertEmpStatus($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function updateEmployeeStatus($id, $post) {
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $post['emp_status_id'],
            '',
            '',
            NULL,
            '',
            '',
            '1',
            1,
            0,
            1,
            $this->user,
            $id
        );
        $result = $this->ObjEmployeeMini->updateEmpStatus($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function addEmployeeUnit($id, $post) {
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $id,
            $post['emp_unit_id'],
            date("Y-m-d"),
            '9999-12-31',
            '',
            '',
            NULL,
            '',
            '',
            1,
            '',
            0,
            1,
            $this->user
        );
        $result = $this->ObjEmployeeMini->insertEmpUnit($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function updateEmployeeUnit($id, $post) {
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $post['emp_unit_id'],
            '',
            '',
            NULL,
            '',
            '',
            1,
            '',
            0,
            1,
            $this->user,
            $id
        );
        $result = $this->ObjEmployeeMini->updateEmpUnit($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function addEmployeeStruct($id, $post) {
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $id,
            $post['emp_position_id'],
            date("Y-m-d"),
            '9999-12-31',
            '',
            '',
            NULL,
            '',
            '',
            1,
            '',
            0,
            1,
            $this->user
        );
        $result = $this->ObjEmployeeMini->insertEmpPosition($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function updateEmployeeStruct($id, $post) {
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $post['emp_position_id'],
            '',
            '',
            NULL,
            '',
            '',
            1,
            '',
            0,
            1,
            $this->user,
            $id
        );
        $result = $this->ObjEmployeeMini->updateEmpPosition($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function addEmployeeType($id, $post) {
        if (!empty($post['emp_type_id'])) {
            $type_id = explode('|', $post['emp_type_id']);
        }
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $id,
            $type_id[0],
            null,
            null,
            date("Y-m-d"),
            '9999-12-31',
            null,
            null,
            null,
            null,
            '',
            '',
            NULL,
            '',
            '',
            1,
            '',
            0,
            1,
            $this->user
        );
        $result = $this->ObjEmployeeMini->insertEmpContract($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function updateEmployeeType($id, $post) {
        if (!empty($post['emp_type_id'])) {
            $type_id = explode('|', $post['emp_type_id']);
        }
        $result = true;
        $this->ObjEmployeeMini->StartTrans();
        $params = array(
            $type_id[0],
            null,
            null,
            null,
            null,
            null,
            null,
            '',
            '',
            NULL,
            '',
            '',
            1,
            '',
            0,
            1,
            $this->user,
            $id
        );
        $result = $this->ObjEmployeeMini->updateEmpContract($params);
        $this->ObjEmployeeMini->EndTrans($result);
        return $result;
    }

    function delete($id) {
        $result = $this->ObjEmployeeMini->deleteEmployeeMini($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('emp.employee.mini', 'EmployeeMini', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>