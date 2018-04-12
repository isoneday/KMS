<?php

/**
 * @author Prima Noor 
 */
class ViewEditEmployeeUser extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_edit_employeeuser.html');
    }

    function ProcessRequest() {
        $ObjEmployeeUser = GtfwDispt()->load->business('EmployeeUser', 'emp.employee.mini');
        $ObjEmployee = GtfwDispt()->load->business('EmployeeMini', 'emp.employee.mini');
        $ObjGroup = GtfwDispt()->load->business('Group', 'core.group');

        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__file__);
        $post = isset($msg[0][0]) ? $msg[0][0] : null;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : null;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : null;

        if (!empty($post)) {
            $emp_id = $post['emp_id'];
            $id = $post['id'];
        } else {
            $emp_id = $_GET['id']->Integer()->Raw();
            $id = $_GET['id']->Integer()->Raw();
        }

        if (!empty($post)) {
            $input = $post;
        } elseif (!empty($id)) {
            $input['group'] = array();
            $input = $ObjEmployeeUser->getDetailEmployeeUser($id);
            if (!empty($input['group'])) {
                $input['group'] = explode(",", $input['group']);
            }
        }

        $application = $ObjEmployeeUser->getApplication();
        foreach ($application as $key => $value) {
            $application[$key]['list_group'] = $ObjGroup->listGroupToEmployee($value['app_id']);
        }
        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $listLang = $ObjLang->listLangCode();
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'lang', array(
            'active_lang_code',
            $listLang,
            !empty($input['active_lang_code']) ? $input['active_lang_code'] : '',
            '',
            ''), Messenger::CurrentRequest);


        return compact('input', 'id', 'emp_id', 'message', 'elmId', 'application', 'emp_detail', 'list_group');
    }

    function ParseTemplate($rdata = null) {
        extract($rdata);
        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }
        if (!empty($application)) {
            $this->mrTemplate->addVar('application', 'IS_EMPTY', 'NO');
            $no = 1;
            foreach ($application as $key => $value) {
                $app_data = array();
                $app_data['number'] = $no + $key;
                $app_data['name'] = $value['app_name'];
                $app_data['id'] = $value['app_id'];
                $title = GtfwLangText('detail');

                $group_data = $application[$key]['list_group'];
                unset($application[$key]['list_group']);

                $this->mrTemplate->addVars('app_item', $app_data);
                $this->mrTemplate->clearTemplate('group_item');

                if (!empty($group_data)) {
                    foreach ($group_data as $key => $val) {
                        $allowDetail = Security::Authorization()->IsAllowedToAccess('core.groupall', 'detailCoreGroupall', 'view', 'html');
                        $data_group = array();
                        $data_group['name'] = $val['name'];
                        $data_group['id'] = $val['id'];
                        if ($allowDetail) {
                            $data_group['title'] = $title;
                            $data_group['url'] = GtfwDispt()->GetUrl('core.groupall', 'detailCoreGroupall', 'view', 'html') . '&id=' . $val['id'] . '&appId=' . $value['app_id'];
                        }
                        if (!empty($input['group']) AND in_array($val['id'], $input['group'])) {
                            $data_group['checked'] = 'checked="checked"';
                        } else {
                            $data_group['checked'] = '';
                        }
                        $this->mrTemplate->addVars('group_item', $data_group);
                        $this->mrTemplate->parseTemplate('group_item', 'a');
                    }
                }
                $this->mrTemplate->parseTemplate('app_item', 'a');
            }
        } else {
            $this->mrTemplate->addVar('application', 'IS_EMPTY', 'YES');
        }

        $status = 'checked="checked"';
        $nstatus = '';
        if (isset($input['status']) && $input['status'] != '1') {
            $status = '';
            $nstatus = 'checked="checked"';
        }

        if (!empty($input)) {
            if (!empty($input['group']))
                unset($input['group']);
            $this->mrTemplate->addVars('content', $input);
        }

        $this->mrTemplate->AddVar('content', 'EMP_ID', $emp_id);
        $this->mrTemplate->AddVar('content', 'STATUS', $status);
        $this->mrTemplate->AddVar('content', 'NSTATUS', $nstatus);

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('emp.employee.mini', 'employeeMini', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'updateEmployeeUser', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>