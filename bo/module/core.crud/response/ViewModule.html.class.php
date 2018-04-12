<?php

/**
 * @author Prima Noor 
 */
class ViewModule extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_module.html');
    }

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('Crud');
        $lang = GtfwLang()->GetLangCode();

        $msg = Messenger::Instance()->Receive(__file__);
        $post = isset($msg[0][0]) ? $msg[0][0] : null;

        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : null;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : null;

        $input = array();
        if (!empty($post)) {
            $action = $post['action'];
            unset($post['action']);
            $filter = $post['filter'];
            unset($post['filter']);
            $data = $post['data'];
            unset($post['data']);
            $input = $post;
        }

        Messenger::Instance()->SendToComponent('core.menu', 'comboMenu', 'view', 'html', 'menu', array('dataId' => (!empty($input['menu']) ? $input['menu'] : null), 'elmId' => 'menu', 'showAdd' => true), Messenger::CurrentRequest);

        $listAction = $Obj->listActions();

        $listTable = $Obj->listTable();
        if (!empty($listTable) and count($listTable) > 0) {
            foreach ($listTable as $table) {
                foreach ($table as $val) {
//                    if (!strstr($val, 'gtfw')) {
                    $tbl['id'] = $val;
                    $tbl['name'] = $val;
                    $tables[] = $tbl;
//                    } else {
//                        break;
//                    }
                }
            }
        }

        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'table', array(
            'table',
            $tables,
            (isset($input['table'])?$input['table']:''),
            'false',
            ' style="" title="Table" tabindex="6"'), Messenger::CurrentRequest);

        return compact('menu', 'listAction', 'message', 'input');
    }

    function ParseTemplate($rdata = null) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('form', $input);
        }

        if (!empty($listAction)) {
            foreach ($listAction as $val) {
                $this->mrTemplate->addVars('actions', $val);
                $this->mrTemplate->parseTemplate('actions', 'a');
            }
        }

        $this->mrTemplate->addVar('content', 'URL_TABLE', GtfwDispt()->GetUrl(GtfwDispt()->mModule, 'table', 'view', 'html'));
        $this->mrTemplate->addVar('form', 'URL_ACTION', GtfwDispt()->GetUrl('core.crud', 'module', 'do', 'html'));
    }

}

?>