<?php

/**
 * @author Prima Noor 
 */

class ViewComboModLogproblem extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/mod.logproblem/template');
        $this->SetTemplateFile('view_combo_modlogproblem.html');
    }

    function ProcessRequest()
    {
        $ObjModLogproblem = GtfwDispt()->load->business('ModLogproblem', 'mod.logproblem');

        $msg = Messenger::Instance()->Receive(__file__, $this->mComponentName); 
        Messenger::Instance()->Receive(__file__);
        $comboData = !empty($msg) ? $msg[count($msg)-1] : null;
        // apakah perlu UntilFetched        
        Messenger::Instance()->Send('mod.logproblem', 'comboModLogproblem', 'view', 'html', $comboData, Messenger::UntilFetched);
        
        $allowAdd = Security::Authorization()->IsAllowedToAccess('mod.logproblem', 'addModLogproblem', 'view', 'html');
        
        $list = $ObjModLogproblem->listModLogproblem();

        return compact('list', 'comboData', 'allowAdd');
    }

    function ParseTemplate($rdata = null)
    {
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
                $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('mod.logproblem', 'addModLogproblem', 'view', 'html').'&elmId='.$comboData['elmId']);
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