<?php

/**
 * @author Prima Noor 
 */
class ViewInputCoreUserall extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_coreuserall.html');
    }

    function ProcessRequest() {
        $ObjCoreUserall = GtfwDispt()->load->business('CoreUserall', 'core.userall');
        $ObjGroup = GtfwDispt()->load->business('CoreGroupall', 'core.groupall');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        if (!empty($post)) {
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjCoreUserall->getDetailCoreUserall($id);
            if (!empty($input)) {
                $input['group'] = explode(',', $input['group']);
            }
        }

        $list_app = $ObjGroup->listApplication();
        foreach ($list_app as $key => $val) {
            $list_app[$key]['list_group'] = $ObjGroup->listGroup($val['id']);
        }

        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $listLang = $ObjLang->listLangCode();
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'lang', array(
            'active_lang_code',
            $listLang,
            !empty($input['active_lang_code']) ? $input['active_lang_code'] : '',
            '',
            ''), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'elmId', 'list_app');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($list_app)) {
            $title = GtfwLangText('detail');
            $allowDetail = Security::Authorization()->IsAllowedToAccess('core.groupall', 'detailCoreGroupall', 'view', 'html');
            for ($i = 0; $i < sizeof($list_app); $i++) {
                $list_group = $list_app[$i]['list_group'];
                unset($list_app[$i]['list_group']);
                $this->mrTemplate->addVars('group', $list_app[$i]);
                $this->mrTemplate->clearTemplate('item');

                if (!empty($list_group)) {
                    foreach ($list_group as $key => $value) {
                        $dataGroup = array();
                        $dataGroup['name'] = $value['name'];
                        $dataGroup['id'] = $value['id'];
                        if ($allowDetail) {
                            $dataGroup['title'] = $title;
                            $dataGroup['url'] = GtfwDispt()->GetUrl('core.groupall', 'detailCoreGroupall', 'view', 'html') . '&id=' . $value['id'] . '&appId=' . $value['application_id'];
                        }
                        if (!empty($input['group']) AND in_array($value['id'], $input['group'])) {
                            $dataGroup['checked'] = 'checked="checked"';
                        } else {
                            $dataGroup['checked'] = '';
                        }
                        $this->mrTemplate->addVars('item', $dataGroup);
                        $this->mrTemplate->parseTemplate('item', 'a');
                    }
                }
                $this->mrTemplate->parseTemplate('group', 'a');
            }
        }

        if (!empty($input)) {
            if (!empty($input['group']))
                unset($input['group']);
            $this->mrTemplate->addVars('content', $input);
            if ($input['active'] == '1')
                $this->mrTemplate->addVar('content', 'CHECK_ACTIVE_1', 'checked=""');
            else
                $this->mrTemplate->addVar('content', 'CHECK_ACTIVE_0', 'checked=""');

            if (!empty($input['id'])) {
                $this->mrTemplate->setAttribute('password', 'visibility', 'hidden');
            }
        } else {
            $this->mrTemplate->addVar('content', 'CHECK_ACTIVE_1', 'checked=""');
        }

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('core.userall', 'CoreUserall', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.userall', (empty($id) ? 'add' : 'update') . 'CoreUserall', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>