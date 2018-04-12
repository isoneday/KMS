<?php

/**
 * @author Prima Noor
 */
class ProcessCmsNews {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjCmsNews = GtfwDispt()->load->business('CmsNews');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $config = array(
            "dest" => Configuration::Instance()->GetValue('application', 'cms_save_path'),
            "ext" => "jpg,png,jpeg,gif,PNG,JPG",
            "maxsize" => 2097152,
        );

        $ObjUpload = GtfwDispt()->load->library('Upload', $config);



        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjCmsNews->StartTrans();

                $upload = $ObjUpload->DoUpload();

                $name_enc = $upload['photo']['name_enc'];
                $name_ori = $upload['photo']['name_ori'];
                $file_path = $upload['photo']['file_path'];
                $file_size = $upload['photo']['file_size'];
                $file_ext = $upload['photo']['file_ext'];


                $params = array(
                    $post['title'],
                    $post['content'],
                    $post['snippet'],
                    $name_enc,
                    $name_ori,
                    $file_path,
                    $file_ext,
                    $file_size,
                    $post['status'],
                    $this->user
                );
                $result = $result && $this->ObjCmsNews->insertCmsNews($params);
                $this->ObjCmsNews->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjCmsNews->StartTrans();

                $name_enc = $post['photo_enc'];
                $name_ori = $post['photo_origin'];
                $file_path = $post['photo_path'];
                $file_size = $post['photo_size'];
                $file_ext = $post['photo_type'];

                $ObjUpload = GtfwDispt()->load->library('Upload', $config);
                $upload = $ObjUpload->DoUpload();

                if (!empty($upload['photo'])) {
                    //function to upload file
                    if (empty($upload['photo']['error'])) {
                        @unlink(Configuration::Instance()->GetValue('application', 'cms_save_path') . $post['photo_enc']);
                        //get data to insert database
                        $name_enc = $upload['photo']['name_enc'];
                        $name_ori = $upload['photo']['name_ori'];
                        $file_path = $upload['photo']['file_path'];
                        $file_ext = $upload['photo']['file_ext'];
                        $file_size = $upload['photo']['file_size'];
                    }
                }

                $params = array(
                    $post['title'],
                    $post['content'],
                    $post['snippet'],
                    $name_enc,
                    $name_ori,
                    $file_path,
                    $file_ext,
                    $file_size,
                    $post['status'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjCmsNews->updateCmsNews($params);
                $this->ObjCmsNews->EndTrans($result);
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
            Messenger::Instance()->Send('cms.news', 'CmsNews', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.news', 'cmsnews', 'view', 'html');
        } else {
            Messenger::Instance()->Send('cms.news', 'inputCmsNews', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.news', (empty($post['id'])?'add':'update').'CmsNews', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = $this->ObjCmsNews->deleteCmsNews($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('cms.news', 'CmsNews', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>