<?php

/**
 * @author Prima Noor 
 */
class ViewInputEmailTemplate extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_emailtemplate.html');
    }

    function ProcessRequest() {
        $ObjEmailTemplate = GtfwDispt()->load->business('EmailTemplate', 'comp.email.template');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        if (!empty($post)) {
            $text = $post['body'];
            unset($post['body']);
            $alt_text = $post['alt_body'];
            unset($post['alt_body']);
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjEmailTemplate->getDetailEmailTemplate($id);
            $text = $ObjEmailTemplate->getDetailEmailTemplateBody($id);
            $alt_text = $ObjEmailTemplate->getDetailEmailTemplateAltBody($id);
        }

        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $langList = $ObjLang->listLangCode();

        return compact('input', 'id', 'message', 'elmId', 'langList', 'text', 'alt_text');
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
        if (!empty($alt_text)) {
            foreach ($alt_text as $alt_key => $alt_val) {
                $this->mrTemplate->addVar('item_body_alt', 'CODE', $alt_key);
                $this->mrTemplate->addVar('item_body_alt', 'ALT_TEXT', $alt_val);
                $this->mrTemplate->parseTemplate('item_body_alt', 'a');
                $this->mrTemplate->addVar('item_body_alt_tiny', 'CODE', $alt_key);
                $this->mrTemplate->parseTemplate('item_body_alt_tiny', 'a');
            }
        } else {
            foreach ($langList as $alt_val) {
                $this->mrTemplate->addVar('item_body_alt', 'CODE', $alt_val['id']);
                $this->mrTemplate->parseTemplate('item_body_alt', 'a');
                $this->mrTemplate->addVar('item_body_alt_tiny', 'CODE', $alt_val['id']);
                $this->mrTemplate->parseTemplate('item_body_alt_tiny', 'a');
            }
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('comp.email.template', 'EmailTemplate', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('comp.email.template', (empty($id) ? 'add' : 'update') . 'EmailTemplate', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>