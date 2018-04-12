<?php

/**
 * @author Prima Noor 
 */
class ViewDetailSmsTemplate extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_smstemplate.html');
    }

    function ProcessRequest() {
        $ObjSmsTemplate = GtfwDispt()->load->business('SmsTemplate', 'comp.sms.template');
        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');

        $id = $_GET['id']->Integer()->Raw();
        $langList = $ObjLang->listLangCode();

        $id = $_GET['id']->Integer()->Raw();

        $detail = $ObjSmsTemplate->getDetailSmsTemplate($id);
        $text = $ObjSmsTemplate->getDetailSmsTemplateBody($id);

        return compact('detail', 'text');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($detail)) {
            if (!empty($text)) {
                foreach ($text as $key => $val) {
                    $this->mrTemplate->addVar('item_body', 'CODE', $key);
                    $this->mrTemplate->addVar('item_body', 'TEXT', $val);
                    $this->mrTemplate->parseTemplate('item_body', 'a');
                }
            } else {
                foreach ($langList as $val) {
                    $this->mrTemplate->addVar('item_body', 'CODE', $val['id']);
                    $this->mrTemplate->parseTemplate('item_body', 'a');
                }
            }
            $this->mrTemplate->addVars('content', $detail);
        }
    }

}

?>