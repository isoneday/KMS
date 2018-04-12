<?php

/**
 * @author Prima Noor
 */
class ProcessCoreCompany {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjCoreCompany = GtfwDispt()->load->business('CoreCompany');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('name', GtfwLangText('name'), 'required');
        $Val->set_rules('country', GtfwLangText('country'), 'required');
        $Val->set_rules('state', GtfwLangText('state'), 'required');
        $Val->set_rules('city', GtfwLangText('city'), 'required');

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjCoreCompany->StartTrans();
                $params = array(
                    $post['name'],
                    $post['address'],
                    $post['country'],
                    $post['state'],
                    $post['city'],
                    $post['postal_code'],
                    $post['phone'],
                    $post['fax'],
                    $this->user
                );
                $result = $result && $this->ObjCoreCompany->insertCoreCompany($params);
                $id = $this->ObjCoreCompany->LastInsertId();
                if ($result) {
                    $config = array(
                        "dest" => Configuration::Instance()->GetValue('application', 'master_save_path'),
                        "ext" => "jpg,png,jpeg,gif",
                        "maxsize" => 2097152,
                    );
                    $ObjUpload = GtfwDispt()->load->library('Upload', $config);

                    $upload = $ObjUpload->doUpload();

                    foreach ($upload as $key => $val) {
                        $params = array(
                            $key,
                            $val['name_ori'],
                            $val['name_enc'],
                            $val['file_ext'],
                            $val['file_size']
                        );
                        $result = $result && $this->ObjCoreCompany->insertCompanyPhoto($params);
                    }
                }
                $this->ObjCoreCompany->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjCoreCompany->StartTrans();
                $params = array(
                    $post['name'],
                    $post['address'],
                    $post['country'],
                    $post['state'],
                    $post['city'],
                    $post['postal_code'],
                    $post['phone'],
                    $post['fax'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjCoreCompany->updateCoreCompany($params);
                if ($result) {
                    $config = array(
                        "dest" => Configuration::Instance()->GetValue('application', 'master_save_path'),
                        "ext" => "jpg,png,jpeg,gif",
                        "maxsize" => 2097152,
                    );
                    $ObjUpload = GtfwDispt()->load->library('Upload', $config);

                    $upload = $ObjUpload->doUpload();

                    foreach ($upload as $key => $val) {
                        $cek_file = $this->ObjCoreCompany->getCompanyPhoto($post['id'], $key);
                        if (!empty($cek_file['0']['photo'])) {
                            @unlink(Configuration::Instance()->GetValue('application', 'master_save_path') . $cek_file['0']['photo']);
                        }

                        $result = $result && $this->ObjCoreCompany->deleteCompanyPhoto($post['id'], $key);

                        if ($result) {
                            $params = array(
                                $post['id'],
                                $key,
                                $val['name_ori'],
                                $val['name_enc'],
                                $val['file_ext'],
                                $val['file_size']
                            );
                            $result = $result && $this->ObjCoreCompany->updateCompanyPhoto($params);
                        }
                    }
                }
                $this->ObjCoreCompany->EndTrans($result);
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
            Messenger::Instance()->Send('core.company', 'CoreCompany', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.company', 'corecompany', 'view', 'html');
        } else {
            Messenger::Instance()->Send('core.company', 'inputCoreCompany', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.company', (empty($post['id'])?'add':'update').'CoreCompany', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = $this->ObjCoreCompany->deleteCoreCompany($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('core.company', 'CoreCompany', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>