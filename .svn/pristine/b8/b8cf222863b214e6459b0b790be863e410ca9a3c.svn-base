<?php

/**
 * @author Prima Noor 
 */
class ViewBottomToolbar extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/comp.toolbar/template');
        $this->SetTemplateFile('view_bottom_toolbar.html');
    }

    function ProcessRequest() {
        return compact('');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);
        $this->mrTemplate->addVar('content', 'URL_MESSAGE', GtfwDispt()->GetUrl('comp.message', 'msgContainer', 'view', 'html'));
    }

}

?>