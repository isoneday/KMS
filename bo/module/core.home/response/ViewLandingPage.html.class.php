<?php

/**
 * @author Prima Noor 
 */
class ViewLandingPage extends HtmlResponse {

    function TemplateBase() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'main/template/');
        $this->SetTemplateFile('document-landing.html');
        $this->SetTemplateFile('layout-landing.html');
    }

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_landing_page.html');
    }

    function ProcessRequest() {
        $ObjMenu = GtfwDispt()->load->business('CompMenu', 'comp.menu');

        $modules = $ObjMenu->listLandingPageMenu();
        return compact('modules');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($modules)) {
            $this->mrTemplate->addVar('module', 'IS_EMPTY', 'NO');
       $msg = GtfwLangText('msg_update_success');        
         $css = $this->cssDone;
     
            foreach ($modules as $val) {
                if (empty($val['icon_large'])) {
                    $val['icon_large'] = 'default_large.png';
                }
                if (empty($val['mod'])) {
                    $val['url'] = GtfwDispt()->GetUrl('core.home', 'home', 'view', 'html').'&mId='.$val['id'];
                } else {
                    $val['url'] = GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']);
                    $val['id'] = NULL;
                }
                $this->mrTemplate->addVars('item_module', $val);
                $this->mrTemplate->parseTemplate('item_module', 'a');
            }
        } else {
            $this->mrTemplate->addVar('module', 'IS_EMPTY', 'YES');
        }
    }

}

?>