<?php

/**
 * @author Prima Noor 
 */
class ViewComboUnit extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/core.unit/template');
        $this->SetTemplateFile('view_combo_unit.html');
    }

    function ProcessRequest() {
        $ObjUnit = GtfwDispt()->load->business('Unit', 'core.unit');

        $msg = Messenger::Instance()->Receive(__file__, $this->mComponentName);
        Messenger::Instance()->Receive(__file__);
        $comboData = !empty($msg) ? $msg[count($msg) - 1] : null;
        // apakah perlu UntilFetched        
        Messenger::Instance()->Send('core.unit', 'comboUnit', 'view', 'html', $comboData, Messenger::UntilFetched);

        $allowAdd = Security::Authorization()->IsAllowedToAccess('core.unit', 'addUnit', 'view', 'html');

        $list = $ObjUnit->listUnit();

        return compact('list', 'comboData', 'allowAdd');
    }

    function ParseTemplate($rdata = null) {
        extract($rdata);

        if (!empty($comboData))
            $this->mrTemplate->addVars('combobox', $comboData);

        if (!empty($comboData['elmId'])) {
            $this->mrTemplate->addVar('combobox', 'ELMID', $comboData['elmId']);

            if (!empty($comboData['showAdd']) and $allowAdd) {
                $this->mrTemplate->setAttribute('button_add', 'visibility', 'show');
                $this->mrTemplate->addVar('button_add', 'ELMID', $comboData['elmId']);
                $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('core.unit', 'addUnit', 'view', 'html') . '&elmId=' . $comboData['elmId']);
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

        if (!empty($list)) {
            foreach ($list as $val) {
                if (!empty($comboData['dataId']) AND $val['id'] == $comboData['dataId']) {
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