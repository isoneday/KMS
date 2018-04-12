<?php

/**
 * @author Prima Noor 
 */
class ViewInputCoreCompany extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_corecompany.html');
    }

    function ProcessRequest() {
        $ObjCoreCompany = GtfwDispt()->load->business('CoreCompany', 'core.company');
        $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');
        $ObjCountry = GtfwDispt()->load->business('Country', 'ref.country');
        $default_country = $ObjSetting->getValue('default_country_code');
        $id_country = $ObjCountry->getDetailCountryByCode($default_country);

        if (isset($id_country['id'])) {
            $id_country = $id_country['id'];
        } else {
            $id_country = 0;
        }
        //init gtUpload untuk javascript upload
        $config = array(
            "form" => "#form_input", //id form atau class form
            "wlext" => "jpg,gif,PNG,txt,doc,docx,pdf,zip,rar,png", //white list ext untuk diupload. optional, default : jpg,png,jpeg,gif,pdf
            "maxsize" => 2097152, //max ukuran yang diperbolehkan. dalam byte. optional, default : mengambil dari ukuran di php.ini. jika maxsize melebihi nilai di php.ini maka nilai ini yang dipakai
            "multi" => false,
            "preview" => true
        );
        Messenger::Instance()->SendToComponent('comp.upload', 'upload', 'do', 'html', '', $config, Messenger::CurrentRequest);

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        if (empty($post['file'])) {
            $input['file'] = $ObjCoreCompany->getPhotoType();
        }

        if (empty($post) && empty($id)) {
            $post['name'] = '';
            $post['address'] = '';
            $post['postal_code'] = '';
            $post['fax'] = '';
            $post['phone'] = '';
        }
        if (!empty($post)) {
            $input = $post;
            if (!empty($id)) {
                $input['file'] = $ObjCoreCompany->getPhotoTypeById($id);
            } else {
                $input['file'] = $ObjCoreCompany->getPhotoType();
            }
        } elseif (!empty($id)) {
            $input = $ObjCoreCompany->getDetailCoreCompany($id);
            $input['file'] = $ObjCoreCompany->getPhotoTypeById($id);
        }

        //for address
        Messenger::Instance()->SendToComponent('ref.country', 'crmComboCountry', 'view', 'html', 'country', array(
            'dataId' => (!empty($input['country']) ? $input['country'] : $id_country),
            'elmId' => 'country',
            'name' => 'country',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('ref.state', 'crmComboState', 'view', 'html', 'state', array(
            'dataId' => (!empty($input['state']) ? $input['state'] : null),
            'elmId' => 'state',
            'name' => 'state',
            'first' => 'select',
            'showAdd' => false,
            'country_id' => (!empty($input['country']) ? $input['country'] : $id_country)), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('ref.city', 'crmComboCity', 'view', 'html', 'city', array(
            'dataId' => (!empty($input['city']) ? $input['city'] : null),
            'elmId' => 'city',
            'name' => 'city',
            'first' => 'select',
            'showAdd' => false,
            'state_id' => (!empty($input['state']) ? $input['state'] : null)), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'elmId');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($input)) {
            $this->mrTemplate->addVar('content', 'ID', $id);
            $this->mrTemplate->addVar('content', 'NAME', $input['name']);
            $this->mrTemplate->addVar('content', 'ADDRESS', $input['address']);
            $this->mrTemplate->addVar('content', 'POSTAL_CODE', $input['postal_code']);
            $this->mrTemplate->addVar('content', 'PHONE', $input['phone']);
            $this->mrTemplate->addVar('content', 'FAX', $input['fax']);

            $this->mrTemplate->addVar('photo_type', 'EMPTY', 'NO');
            if (!empty($id)) {
                $this->mrTemplate->setAttribute('th_prev_file', 'visibility', 'visible');
                $this->mrTemplate->setAttribute('prev_file', 'visibility', 'visible');
            }

            $i = 0;
            for ($i = 0; $i < sizeof($input['file']); $i++) {

                $input['file'][$i]['no'] = $i + 1;
                $input['file'][$i]['key'] = $i;

                if ((!empty($input['file'][$i]['photo_ori'])) && is_readable(Configuration::Instance()->GetValue('application', 'master_save_path') . $input['file'][$i]['photo_enc'])) {
                    $path = Configuration::Instance()->GetValue('application', 'master_save_path') . $input['file'][$i]['photo_enc'];
                    $input['file'][$i]['preview'] = "<img src=" . $path . " width=110px height=140px alt='" . $input['file'][$i]['photo_ori'] . "' title='" . $input['file'][$i]['photo_ori'] . "'>";
                    $this->mrTemplate->AddVars('prev_file', $input['file'][$i]);
                } else {
                    $input['file'][$i]['note'] = GtfwLangText('there_is_no_current_file');
                }

                $this->mrTemplate->addVars('item_photo', $input['file'][$i]);
                $this->mrTemplate->parseTemplate('item_photo', 'a');
            }
        } else {
            $this->mrTemplate->addVar('photo_type', 'EMPTY', 'NO');
            $i = 0;

            for ($i = 0; $i < sizeof($file); $i++) {

                $file[$i]['no'] = $i + 1;
                $file[$i]['key'] = $i;

                $this->mrTemplate->addVars('item_photo', $file[$i]);
                $this->mrTemplate->parseTemplate('item_photo', 'a');
            }
        }

        $this->mrTemplate->addVar('content', 'URL_COUNTRY', GtfwDispt()->GetUrl('ref.country', 'crmComboCountry', 'view', 'html') . '&ascomponent=1');
        $this->mrTemplate->addVar('content', 'URL_STATE', GtfwDispt()->GetUrl('ref.state', 'crmComboState', 'view', 'html') . '&ascomponent=1');
        $this->mrTemplate->addVar('content', 'URL_CITY', GtfwDispt()->GetUrl('ref.city', 'crmComboCity', 'view', 'html') . '&ascomponent=1');
        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('core.company', 'CoreCompany', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.company', (empty($id) ? 'add' : 'update') . 'CoreCompany', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>