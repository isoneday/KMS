<?php

/**
 * @author Prima Noor
 */

class ProcessUpload
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        //$this->Obj = GtfwDispt()->load->business('Upload');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        //init untuk gtupload server side. parameter yang optional bisa ditinggalkan
        $config = array('dest' => 'files', //direktori untuk upload file
                'ext' =>'jpg,png,jpeg,gif', //white list ekstensi file, optional. default : jpg,png,jpeg,gif,pdf
                //'maxsize' => 2048 // maksmum file yang boleh diupload. optional. default : nilai di php.ini.
            );
        //memanggil  library Upload, dan menginisialisai parameter diatas
        $ObjUpload = GtfwDispt()->load->library('Upload', $config);

        $result = $ObjUpload->doUpload();
        echo '<pre>'; print_r($ObjUpload->showError()); echo '</pre>';
        echo '<pre>'; print_r($result); echo '</pre>';exit;
        if (!empty($result) AND empty($result['file1']['error'])) {
            $file = GtfwCfg('application', 'docroot').'files/'.$result['file1']['name_enc'];
            $ImgResObj = Dispatcher::Instance()->load->library('ImageResize', $file);
            $ImgResObj->resizeImage(50, 50);
            $ImgResObj->saveImage($file);
        }

        if (!empty($result))    
        if (empty($result['file']['error'])) {
            Messenger::Instance()->Send('testing', 'upload', 'view', 'html', array(
                null,
                'Upload berhasil <br />'.implode('<br />', $result['file']),
                $this->cssDone), Messenger::NextRequest);
        } else {
            echo '<pre>'; print_r($ObjUpload->ShowError()); echo '</pre>';exit;
            Messenger::Instance()->Send('testing', 'upload', 'view', 'html', array(
                null,
                'Upload gagal <br />'.implode('<br />', $ObjUpload->ShowError()),
                $this->cssFail), Messenger::NextRequest);
        }

        return $result;
    }
}

?>