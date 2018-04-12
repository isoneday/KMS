<?php

/**
 * @author Prima Noor 
 */
class ViewDetailEmailTemplate extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_emailtemplate.html');
    }

    function ProcessRequest() {
        $ObjEmailTemplate = GtfwDispt()->load->business('EmailTemplate', 'comp.email.template');
        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');

        $id = $_GET['id']->Integer()->Raw();
        $langList = $ObjLang->listLangCode();

        $detail = $ObjEmailTemplate->getDetailEmailTemplate($id);
        $text = $ObjEmailTemplate->getDetailEmailTemplateBody($id);
        $alt_text = $ObjEmailTemplate->getDetailEmailTemplateAltBody($id);

        return compact('detail', 'langList', 'text', 'alt_text');
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
            if (!empty($alt_text)) {
                foreach ($alt_text as $alt_key => $alt_val) {
                    $this->mrTemplate->addVar('item_body_alt', 'CODE', $alt_key);
                    $this->mrTemplate->addVar('item_body_alt', 'ALT_TEXT', $alt_val);
                    $this->mrTemplate->parseTemplate('item_body_alt', 'a');
                }
            } else {
                foreach ($langList as $alt_val) {
                    $this->mrTemplate->addVar('item_body_alt', 'CODE', $alt_val['id']);
                    $this->mrTemplate->parseTemplate('item_body_alt', 'a');
                }
            }
            $this->mrTemplate->addVars('content', $detail);
        }
    }

}

?>