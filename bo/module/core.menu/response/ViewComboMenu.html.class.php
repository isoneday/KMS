<?php

/**
 * @author Prima Noor 
 */
class ViewComboMenu extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/core.menu/template');
        $this->SetTemplateFile('view_combobox.html');
    }

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CoreMenu', 'core.menu');

        $msg = Messenger::Instance()->Receive(__file__, $this->mComponentName);
        Messenger::Instance()->Receive(__file__);
        $comboData = !empty($msg) ? $msg[count($msg) - 1] : null;
        // apakah perlu UntilFetched
        Messenger::Instance()->Send('core.menu', 'comboMenu', 'view', 'html', $comboData, Messenger::UntilFetched);

        $allowAdd = Security::Authorization()->IsAllowedToAccess('core.menu', 'addMenu', 'view', 'html');

        $menu = $Obj->listMenu();

        return compact('menu', 'comboData', 'allowAdd');
    }

    function ParseTemplate($rdata = null) {
        extract($rdata);

        if (!empty($comboData)) {
            $comboData['name'] = empty($comboData['name']) ? $comboData['elmId'] : $comboData['name'];
            $this->mrTemplate->addVars('combobox', $comboData);
        }

        if (!empty($comboData['elmId'])) {
            $this->mrTemplate->addVar('combobox', 'ELMID', $comboData['elmId']);

            if (!empty($comboData['showAdd']) and $allowAdd) {
                $this->mrTemplate->setAttribute('button_add', 'visibility', 'show');
                $this->mrTemplate->addVar('button_add', 'ELMID', $comboData['elmId']);
                $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('core.menu', 'addMenu', 'view', 'html') . '&elmId=' . $comboData['elmId']);
            }
        }

        if (!empty($comboData['first'])) {
            if ($comboData['first'] === 'all') {
                $this->mrTemplate->addVar('combolist', 'ID', 'all');
                $this->mrTemplate->addVar('combolist', 'NAME', "-- " . ucwords(GtfwLangText('all')) . " --");
                $this->mrTemplate->parseTemplate('combolist', 'a');
            } elseif ($comboData['first'] === 'select') {
                $this->mrTemplate->addVar('combolist', 'ID', '');
                $this->mrTemplate->addVar('combolist', 'NAME', "-- " . ucwords(GtfwLangText('select')) . " --");
                $this->mrTemplate->parseTemplate('combolist', 'a');
            }
        }

        if (!empty($menu)) {
            foreach ($menu as $val) {
                if (!empty($comboData['dataId']) and $val['id'] == $comboData['dataId']) {
                    $val['selected'] = 'selected=""';
                } else {
                    $val['selected'] = '';
                }
                $this->mrTemplate->addVars('combolist', $val);
                $this->mrTemplate->parseTemplate('combolist', 'a');
            }
        }
    }

}

?>