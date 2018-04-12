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
 $config = array(
            "form" => "#form_input", //id form atau class form
            "wlext" => "jpg,gif,PNG,png,jpeg", //white list ext untuk diupload. optional, default : jpg,png,jpeg,gif,pdf
            "maxsize" => 2097152, //max ukuran yang diperbolehkan. dalam byte. optional, default : mengambil dari ukuran di php.ini. jika maxsize melebihi nilai di php.ini maka nilai ini yang dipakai
            "multi" => false,
            "preview" => true
        );
        Messenger::Instance()->SendToComponent('comp.upload', 'upload', 'do', 'html', '', $config, Messenger::CurrentRequest);

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
        Messenger::Instance()->SendToComponent('emp.ref.employee.type', 'comboRefEmpType', 'view', 'html', 'emptype_id', array(
            'dataId' => (!empty($input['emptype_id']) ? $input['emptype_id'] : null),
            'elmId' => 'emptype_id',
            'name' => 'emptype_id',
            'type' => 'transfer',
            'first' => 'select',
            'showAdd' => false,
            'style' => 'required'), Messenger::CurrentRequest);


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
if ((!empty($input['photo'])) && is_readable(Configuration::Instance()->GetValue('application', 'aplikan_photo') . $input['photo_path'])) {
            $path = Configuration::Instance()->GetValue('application', 'aplikan_photo') . $input['photo_path'];
            if (($input['photo_type'] == 'jpg') || ($input['photo_type'] == 'PNG') || ($input['photo_type'] == 'gif')) {
                $input['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $input['photo'] . "</a></b>";
                $input['photop'] = "<img src=" . $path . " width=200px height=170px alt='" . $input['photo_origin'] . "' title='" . $input['photo_origin'] . "'>";
                $this->mrTemplate->SetAttribute('photo_preview', 'visibility', 'visible');
                $this->mrTemplate->addVar('photo_preview', 'PHOTOP', $input['photop']);
                #$this->mrTemplate->AddVars('preview', $input, '');
            } else {
                $input['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $input['photo_origin'] . "</a></b>";
                $input['photop'] = '';
            }
            $this->mrTemplate->SetAttribute('current_photo', 'visibility', 'visible');
            $this->mrTemplate->addVar('current_photo', 'PHOTO_FILE', $input['photo_file']);
            $this->mrTemplate->addVar('current_photo', 'ID_PHOTO', $input['id_photo']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO', $input['photo']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO_ORIGIN', $input['photo_origin']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO_PATH', $input['photo_path']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO_TYPE', $input['photo_type']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO_SIZE', $input['photo_size']);
            #$this->mrTemplate->AddVars('current_logo', $input, '');
        } else {
            $input['note'] = GtfwLangText('there_is_no_current_file');
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