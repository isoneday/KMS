<?php

/**
 * @author Prima Noor 
 */
class ViewInputCmsNews extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_cmsnews.html');
    }

    function ProcessRequest() {
        $ObjCmsNews = GtfwDispt()->load->business('CmsNews', 'cms.news');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        if (!empty($post)) {
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjCmsNews->getDetailCmsNews($id);
        }

        //init gtUpload untuk javascript upload
        $config = array(
            "form" => "#form_input", //id form atau class form
            "wlext" => "jpg,png,jpeg,gif", //white list ext untuk diupload. optional, default : jpg,png,jpeg,gif,pdf
            "maxsize" => 2097152, //max ukuran yang diperbolehkan. dalam byte. optional, default : mengambil dari ukuran di php.ini. jika maxsize melebihi nilai di php.ini maka nilai ini yang dipakai
            "preview" => true);
        Messenger::Instance()->SendToComponent('comp.upload', 'upload', 'do', 'html', '', $config, Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'elmId');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $path = Configuration::Instance()->GetValue('application', 'cms_save_path') . $input['photo'];
        if (($input['photo_type'] == 'jpg') || ($input['photo_type'] == 'PNG') || ($input['photo_type'] == 'gif') || ($input['photo_type'] == 'png')) {
            $input['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $input['photo_origin'] . "</a></b>";
            $input['photop'] = "<img src=" . $path . " width='100' height='100' alt='" . $input['photo_origin'] . "' title='" . $input['photo_origin'] . "'>";
            $this->mrTemplate->SetAttribute('photo_preview', 'visibility', 'visible');
            $this->mrTemplate->addVar('photo_preview', 'PHOTOP', $input['photop']);
            #$this->mrTemplate->AddVars('preview', $input, '');
        } else {
            $input['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $input['photo_origin'] . "</a></b>";
            $input['photop'] = '';
        }

        $status = 'checked="checked"';
        $nstatus = '';

        if (isset($input['status']) && $input['status'] != '1') {
            $status = '';
            $nstatus = 'checked="checked"';
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }

        $this->mrTemplate->AddVar('content', 'STATUS', $status);
        $this->mrTemplate->AddVar('content', 'NSTATUS', $nstatus);
        $this->mrTemplate->SetAttribute('current_photo', 'visibility', 'visible');
        $this->mrTemplate->addVar('current_photo', 'PHOTO_FILE', $input['photo_file']);
        $this->mrTemplate->addVar('current_photo', 'PHOTO', $input['photo']);
        $this->mrTemplate->addVar('current_photo', 'PHOTO_ORIGIN', $input['photo_origin']);
        $this->mrTemplate->addVar('current_photo', 'PHOTO_PATH', $input['photo_path']);
        $this->mrTemplate->addVar('current_photo', 'PHOTO_TYPE', $input['photo_type']);
        $this->mrTemplate->addVar('current_photo', 'PHOTO_SIZE', $input['photo_size']);

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('cms.news', 'CmsNews', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('cms.news', (empty($id) ? 'add' : 'update') . 'CmsNews', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>