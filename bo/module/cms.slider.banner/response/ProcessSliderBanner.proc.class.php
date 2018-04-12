<?php

/**
 * @author Prima Noor
 */
class ProcessSliderBanner {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjSliderBanner = GtfwDispt()->load->business('SliderBanner');
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


        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjSliderBanner->StartTrans();

                $ObjUpload = GtfwDispt()->load->library('Upload', $config);
                $upload = $ObjUpload->DoUpload();

                $name_enc = $upload['photo']['name_enc'];
                $name_ori = $upload['photo']['name_ori'];
                $file_path = $upload['photo']['file_path'];
                $file_size = $upload['photo']['file_size'];
                $file_ext = $upload['photo']['file_ext'];

                $params = array(
                    $post['title'],
                    $name_enc,
                    $name_ori,
                    $file_path,
                    $file_ext,
                    $file_size,
                    $post['status'],
                    $this->user
                );
                $result = $result && $this->ObjSliderBanner->insertSliderBanner($params);
                $this->ObjSliderBanner->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjSliderBanner->StartTrans();

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
                    $name_enc,
                    $name_ori,
                    $file_path,
                    $file_ext,
                    $file_size,
                    $post['status'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjSliderBanner->updateSliderBanner($params);
                $this->ObjSliderBanner->EndTrans($result);
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
            Messenger::Instance()->Send('cms.slider.banner', 'SliderBanner', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.slider.banner', 'sliderbanner', 'view', 'html');
        } else {
            Messenger::Instance()->Send('cms.slider.banner', 'inputSliderBanner', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.slider.banner', (empty($post['id'])?'add':'update').'SliderBanner', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = $this->ObjSliderBanner->deleteSliderBanner($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('cms.slider.banner', 'SliderBanner', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>