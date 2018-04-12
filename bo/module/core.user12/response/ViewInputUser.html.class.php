<?php

/**
 * @author Prima Noor 
 */
class ViewInputUser extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_user.html');
    }

    function ProcessRequest() {
        $ObjUser = GtfwDispt()->load->business('User', 'core.user');
        $ObjGroup = GtfwDispt()->load->business('Group', 'core.group');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__file__);
        $post = isset($msg[0][0]) ? $msg[0][0] : null;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : null;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : null;

        if (!empty($post)) {
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjUser->getDetailUser($id);
            if (!empty($input)) {
                $input['group'] = explode(',', $input['group']);
            }
        }

        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $listLang = $ObjLang->listLangCode();
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'lang', array(
            'active_lang_code',
            $listLang,
            !empty($input['active_lang_code']) ? $input['active_lang_code'] : '',
            '',
            ''), Messenger::CurrentRequest);

        $listGroup = $ObjGroup->listGroup();

        $nav[0]['url'] = GtfwDispt()->GetUrl('core.user', 'user', 'view', 'html') . '&display';
        $nav[0]['menu'] = 'User';
        $title = empty($id) ? GtfwLangText('add') : GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array(
            $title,
            $nav,
            'breadcrump',
            '',
            ''), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'elmId', 'listGroup');
    }

    function ParseTemplate($rdata = null) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($listGroup)) {
            $title = GtfwLangText('detail');
            $allowDetail = Security::Authorization()->IsAllowedToAccess('core.group', 'detailGroup', 'view', 'html');
            foreach ($listGroup as $value) {
                $dataGroup = array();
                $dataGroup['name'] = $value['name'];
                $dataGroup['id'] = $value['id'];
                if ($allowDetail) {
                    $dataGroup['title'] = $title;
                    $dataGroup['url'] = GtfwDispt()->GetUrl('core.group', 'detailGroup', 'view', 'html') . '&id=' . $value['id'];
                }
                if (!empty($input['group']) AND in_array($value['id'], $input['group'])) {
                    $dataGroup['checked'] = 'checked="checked"';
                } else {
                    $dataGroup['checked'] = '';
                }
                $this->mrTemplate->addVars('group', $dataGroup);
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

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('core.user', 'user', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.user', (empty($id) ? 'add' : 'update') . 'User', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>