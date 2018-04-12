<?php

/**
 * @author Prima Noor 
 */
class ViewInput extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input.html');
    }

    function ProcessRequest() {
        $dataId = $_GET['dataId']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();
        $lang = GtfwLang()->GetLangCode();

        $Obj = GtfwDispt()->load->business('CoreMenu', 'core.menu');

        $msg = Messenger::Instance()->Receive(__file__);
        $post = isset($msg[0][0]) ? $msg[0][0] : null;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : null;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : null;

        if ($post) {
            $text = $post['menu'];
            unset($post['menu']);
            $text_desc = $post['menu_desc'];
            unset($post['menu_desc']);
            $input = $post;
        } elseif ($dataId) {
            $input = $Obj->getDetail($dataId);
            $text = $Obj->getMenuText($dataId);
            $text_desc = $Obj->getMenuTextDesc($dataId);
        }

        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $langList = $ObjLang->listLangCode();

        $listParent = $Obj->listMenu($lang);
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'parent', array(
            'parent',
            $listParent,
            (!empty($input['parent']) ? $input['parent'] : ''),
            'false',
            ' style="" title="Parent" tabindex="1"'), Messenger::CurrentRequest);
        $listYes = array(array('id' => 'Yes', 'name' => 'Yes'), array('id' => 'No', 'name' => 'No'));
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'show', array(
            'show',
            $listYes,
            (!empty($input['show']) ? $input['show'] : ''),
            '',
            ' style="" title="Show" tabindex="5"'), Messenger::CurrentRequest);

        return compact('input', 'text', 'text_desc', 'langList', 'dataId', 'message', 'elmId');
    }

    function ParseTemplate($rdata = null) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($input) AND $input['is_system_menu'] == 1) {
            $input['LAST_MENU'] = 'checked="checked"';
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }

        if (!empty($text)) {
            foreach ($text as $key => $val) {
                $this->mrTemplate->addVar('item_menu', 'CODE', $key);
                $this->mrTemplate->addVar('item_menu', 'TEXT', $val);
                $this->mrTemplate->parseTemplate('item_menu', 'a');
            }
        } else {
            foreach ($langList as $val) {
                $this->mrTemplate->addVar('item_menu', 'CODE', $val['id']);
                $this->mrTemplate->parseTemplate('item_menu', 'a');
            }
        }

        if (!empty($text_desc)) {
            foreach ($text_desc as $key_desc => $val_desc) {
                $this->mrTemplate->addVar('item_menu_desc', 'CODE', $key_desc);
                $this->mrTemplate->addVar('item_menu_desc', 'TEXT', $val_desc);
                $this->mrTemplate->parseTemplate('item_menu_desc', 'a');
                $this->mrTemplate->addVar('item_body_tiny', 'CODE', $key_desc);
                $this->mrTemplate->parseTemplate('item_body_tiny', 'a');
            }
        } else {
            foreach ($langList as $val_desc) {
                $this->mrTemplate->addVar('item_menu_desc', 'CODE', $val_desc['id']);
                $this->mrTemplate->parseTemplate('item_menu_desc', 'a');
                $this->mrTemplate->addVar('item_body_tiny', 'CODE', $val_desc['id']);
                $this->mrTemplate->parseTemplate('item_body_tiny', 'a');
            }
        }


        $status = 'checked="checked"';
        $nstatus = '';

        if (isset($input['view_model']) && $input['view_model'] != '1') {
            $status = '';
            $nstatus = 'checked="checked"';
        }

        $this->mrTemplate->AddVar('content', 'MODEL', $status);
        $this->mrTemplate->AddVar('content', 'NMODEL', $nstatus);

        $this->mrTemplate->addVar('content', 'URL_ACTION', GtfwDispt()->GetUrl('core.menu', (empty($dataId) ? 'addMenu' : 'updateMenu'), 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>