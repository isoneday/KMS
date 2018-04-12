<?php

/**
 * @author Prima Noor 
 */
class ViewInputEmployeeMini extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_employeemini.html');
    }

    function ProcessRequest() {
        $ObjEmployeeMini = GtfwDispt()->load->business('EmployeeMini', 'emp.employee.mini');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;
        //init gtUpload untuk javascript upload
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
            $input = $ObjEmployeeMini->getDetailEmployeeMini($id);
        }
        //combo salutaion
        Messenger::Instance()->SendToComponent('ref.salutation', 'comboSalutation', 'view', 'html', 'salutation_id', array(
            'dataId' => (!empty($input['salutation_id']) ? $input['salutation_id'] : null),
            'elmId' => 'salutation_id',
            'first' => 'select',
            'showAdd' => false,
            'name' => 'salutation_id',
            'style' => '',
            'script' => ''), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('emp.ref.employee.status', 'comboRefEmpStatus', 'view', 'html', 'emp_status_id', array(
            'dataId' => (!empty($input['emp_status_id']) ? $input['emp_status_id'] : null),
            'elmId' => 'emp_status_id',
            'name' => 'emp_status_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('core.unit', 'comboUnit', 'view', 'html', 'emp_unit_id', array(
            'dataId' => (!empty($input['emp_unit_id']) ? $input['emp_unit_id'] : null),
            'elmId' => 'emp_unit_id',
            'name' => 'emp_unit_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('ref.structural.position.type', 'comboStructPositionType', 'view', 'html', 'emp_position_id', array(
            'dataId' => (!empty($input['emp_position_id']) ? $input['emp_position_id'] : null),
            'elmId' => 'emp_position_id',
            'name' => 'emp_position_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('emp.ref.employee.type', 'comboRefEmpType', 'view', 'html', 'emp_type_id', array(
            'dataId' => (!empty($input['emp_type_id']) ? $input['emp_type_id'] : null),
            'elmId' => 'emp_type_id',
            'name' => 'emp_type_id',
            'type' => 'transfer',
            'first' => 'select',
            'showAdd' => false,
            'style' => 'required'), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'elmId');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $gender = 'checked="checked"';
        $ngender = '';
        if (isset($input['gender']) && $input['gender'] != 'm') {
            $gender = '';
            $ngender = 'checked="checked"';
        }
        if ((!empty($input['photo'])) && is_readable(Configuration::Instance()->GetValue('application', 'employee_save_path') . $input['photo_path'])) {
            $path = Configuration::Instance()->GetValue('application', 'employee_save_path') . $input['photo_path'];
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
            $this->mrTemplate->addVar('current_photo', 'PHOTO_ID', $input['photo_id']);
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
            $this->mrTemplate->addVars('content', $input);
        }

        $this->mrTemplate->AddVar('content', 'GENDER', $gender);
        $this->mrTemplate->AddVar('content', 'NGENDER', $ngender);
        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('emp.employee.mini', 'EmployeeMini', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', (empty($id) ? 'add' : 'update') . 'EmployeeMini', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>