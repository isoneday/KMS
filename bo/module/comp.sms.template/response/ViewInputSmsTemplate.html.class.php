<?php

/**
 * @author Prima Noor 
 */
class ViewInputSmsTemplate extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_smstemplate.html');
    }

    function ProcessRequest() {
        $ObjSmsTemplate = GtfwDispt()->load->business('SmsTemplate', 'comp.sms.template');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $langList = $ObjLang->listLangCode();

        if (!empty($post)) {
            $text = $post['body'];
            unset($post['body']);
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjSmsTemplate->getDetailSmsTemplate($id);
            $text = $ObjSmsTemplate->getDetailSmsTemplateBody($id);
        }

        return compact('input', 'id', 'message', 'elmId', 'langList', 'text');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($text)) {
            foreach ($text as $key => $val) {
                $this->mrTemplate->addVar('item_body', 'CODE', $key);
                $this->mrTemplate->addVar('item_body', 'TEXT', $val);
                $this->mrTemplate->parseTemplate('item_body', 'a');
                $this->mrTemplate->addVar('item_body_tiny', 'CODE', $key);
                $this->mrTemplate->parseTemplate('item_body_tiny', 'a');
            }
        } else {
            foreach ($langList as $val) {
                $this->mrTemplate->addVar('item_body', 'CODE', $val['id']);
                $this->mrTemplate->parseTemplate('item_body', 'a');
                $this->mrTemplate->addVar('item_body_tiny', 'CODE', $val['id']);
                $this->mrTemplate->parseTemplate('item_body_tiny', 'a');
            }
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('comp.sms.template', 'SmsTemplate', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('comp.sms.template', (empty($id) ? 'add' : 'update') . 'SmsTemplate', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>