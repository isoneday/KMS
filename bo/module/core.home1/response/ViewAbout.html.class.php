<?php

/**
 * @author Prima Noor 
 */
class ViewAbout extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/core.home/template');
        $this->SetTemplateFile('view_about.html');
    }

    function ProcessRequest() {
        return compact('');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);
    }

}

?>