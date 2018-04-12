<?php

/**
 * @author Prima Noor 
 */

class ViewUpload extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_upload.html');
    }

    function ProcessRequest()
    {
        $msg = Messenger::Instance()->Receive(__file__);
        $message['content'] = !empty($msg[0][1]) ? $msg[0][1] : null;
        $message['style'] = !empty($msg[0][2]) ? $msg[0][2] : null;
        //init gtUpload untuk javascript upload
        $config = array(
            "form" => "#form_upload", //id form atau class form
            "wlext" => "jpg,png,jpeg,gif", //white list ext untuk diupload. optional, default : jpg,png,jpeg,gif,pdf
            "maxsize" => 2097152, //max ukuran yang diperbolehkan. dalam byte. optional, default : mengambil dari ukuran di php.ini. jika maxsize melebihi nilai di php.ini maka nilai ini yang dipakai
            "preview" => true);
        Messenger::Instance()->SendToComponent('comp.upload', 'upload', 'do', 'html', '', $config, Messenger::CurrentRequest);

        return compact('message');
    }

    function ParseTemplate($rdata = null)
    {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.sample', 'Upload', 'do', 'json'));
    }
}

?>