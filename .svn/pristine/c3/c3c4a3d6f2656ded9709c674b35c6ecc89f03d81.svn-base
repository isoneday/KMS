<?php

/**
 * @author Prima Noor 
 */
class ViewEmployeeMini extends HtmlResponse {

    var $mode;

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        if ($this->mode == 'detail')
            $this->SetTemplateFile('view_employeemini_thumb.html');
        else
            $this->SetTemplateFile('view_employeemini.html');
    }

    function ProcessRequest() {
        $ObjEmployeeMini = GtfwDispt()->load->business('EmployeeMini', 'emp.employee.mini');
        $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');

        $msg = Messenger::Instance()->Receive(__FILE__);
        $filter_data = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[1][1]) ? $msg[1][1] : NULL;
        $message['style'] = isset($msg[1][2]) ? $msg[1][2] : NULL;

        if (!isset($_GET['display']) || empty($filter_data)) {
            $page = 1;
            $start = 0;
            $mode = 'list';
            $display = $ObjSetting->getValue('view_per_page');
            $filter = compact('page', 'display', 'start', 'mode');
        } elseif ($_GET['display']->Raw() != '') {
            $page = (int) $_GET['page']->SqlString()->Raw();
            $display = (int) $_GET['display']->SqlString()->Raw();

            if ($page < 1)
                $page = 1;
            if ($display < 1)
                $display = $ObjSetting->getValue('view_per_page');
            $start = ($page - 1) * $display;

            $filter = compact('page', 'display', 'start');
            $filter += $filter_data;
        } else {
            $filter = $filter_data;
            $page = $filter['page'];
            $display = $filter['display'];
            $start = $filter['start'];
        }

        $post_data = $_POST->AsArray();
        if (isset($post_data))
            foreach ($post_data as $key => $value)
                $filter[$key] = $value;
        $this->mode = $filter['mode'];

        Messenger::Instance()->SendToComponent('emp.ref.employee.type', 'comboRefEmpType', 'view', 'html', 'type_id', array(
            'dataId' => (!empty($filter['type_id']) ? $filter['type_id'] : null),
            'elmId' => 'type_id',
            'first' => 'all',
            'showAdd' => false,
            'name' => 'type_id',
            'style' => '',
            'script' => ''), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('emp.ref.employee.status', 'comboRefEmpStatus', 'view', 'html', 'status_id', array(
            'dataId' => (!empty($filter['status_id']) ? $filter['status_id'] : null),
            'elmId' => 'status_id',
            'first' => 'all',
            'showAdd' => false,
            'name' => 'status_id',
            'style' => '',
            'script' => ''), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('ref.structural.position.type', 'comboStructPositionType', 'view', 'html', 'position_id', array(
            'dataId' => (!empty($filter['position_id']) ? $filter['position_id'] : null),
            'elmId' => 'position_id',
            'first' => 'all',
            'showAdd' => false,
            'name' => 'position_id',
            'style' => '',
            'script' => ''), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('core.unit', 'comboUnit', 'view', 'html', 'unit_id', array(
            'dataId' => (!empty($filter['unit_id']) ? $filter['unit_id'] : null),
            'elmId' => 'unit_id',
            'first' => 'all',
            'showAdd' => false,
            'name' => 'unit_id',
            'style' => '',
            'script' => ''), Messenger::CurrentRequest);

        Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);

        $data = $ObjEmployeeMini->getEmployeeMini($filter);
        $total = $ObjEmployeeMini->countEmployeeMini();

        $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
        Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
        Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);

        return compact('data', 'message', 'filter');
    }

    function ParseTemplate($rdata = NULL) {
        $actions = $this->ButtonRendering();
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl() . '&display');
        if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }

        if (!empty($data) AND count($data) > 0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = $filter['start'] + 1;
            foreach ($data as $val) {
                $val['no'] = $no;
                $val['url_detail'] = GtfwDispt()->GetUrl('emp.employee.mini', 'detailEmployeeMini', 'view', 'html') . '&id=' . $val['id'];

                $this->mrTemplate->clearTemplate('button_update');
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'updateEmployeeMini', 'view', 'html') . '&id=' . $val['id']);

                $this->mrTemplate->clearTemplate('button_create_user');
                $this->mrTemplate->addVar('button_create_user', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'addEmployeeUser', 'view', 'html') . '&id=' . $val['id']);

                $this->mrTemplate->clearTemplate('button_update_user');
                $this->mrTemplate->addVar('button_update_user', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'editEmployeeUser', 'view', 'html') . '&id=' . $val['id']);

                if (in_array('create_user', $actions)) {
                    if (!empty($val['user_id'])) {
                        $this->mrTemplate->SetAttribute('button_create_user', 'visibility', 'hidden');
                        $this->mrTemplate->SetAttribute('button_update_user', 'visibility', 'show');
                    } else {
                        $this->mrTemplate->SetAttribute('button_create_user', 'visibility', 'show');
                        $this->mrTemplate->SetAttribute('button_update_user', 'visibility', 'hidden');
                    }
                }

                $this->mrTemplate->clearTemplate('button_reset_password');
                $this->mrTemplate->addVar('button_reset_password', 'NAME', $val['full_name']);
                $this->mrTemplate->addVar('button_reset_password', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'resetEmployeePassword', 'do', 'json') . '&id=' . $val['id']);
                if (in_array('reset_password', $actions)) {
                    if (empty($val['user_id']))
                        $this->mrTemplate->SetAttribute('button_reset_password', 'visibility', 'hidden');
                    else
                        $this->mrTemplate->SetAttribute('button_reset_password', 'visibility', 'show');
                }

                $this->mrTemplate->clearTemplate('button_create_officer');
                $this->mrTemplate->addVar('button_create_officer', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'inputEmployeeOfficer', 'view', 'html') . '&id=' . $val['id']);
                if (($val['emp_position'] != '- ') && ($val['emp_unit'] != '- ')) {
                    $this->mrTemplate->SetAttribute('button_create_officer', 'visibility', 'show');
                } else {
                    $this->mrTemplate->SetAttribute('button_create_officer', 'visibility', 'hidden');
                }

                $this->mrTemplate->clearTemplate('button_delete');
                $this->mrTemplate->addVar('button_delete', 'NAME', $val['full_name']);
                $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'deleteEmployeeMini', 'do', 'json') . '&id=' . $val['id']);

                if ($this->mode == 'detail') {
                    if ((!empty($val['photo'])) && is_readable(Configuration::Instance()->GetValue('application', 'employee_save_path') . $val['photo_path'])) {
                        $path = Configuration::Instance()->GetValue('application', 'employee_save_path') . $val['photo_path'];
                        $val['attachment'] = "<img src=" . $path . " class='rounded' width=110px height=140px alt='" . $val['photo'] . "' title='" . $val['photo'] . "'><img border='0' class='shadow-driver' src='assets/images/shadow.jpg'>";
                    } else {
                        $path_female = Configuration::Instance()->GetValue('application', 'employee_save_path') . 'user-photo-female.jpg';
                        $path_male = Configuration::Instance()->GetValue('application', 'employee_save_path') . 'user-photo-male.jpg';
                        if ($val['gender'] == 'm') {
                            $val['attachment'] = "<img src=" . $path_male . " class='rounded' width=110px height=140px alt='Male' title='Male Employee'> <img border='0' class='shadow-driver' src='assets/images/shadow.jpg'>";
                        } else {
                            $val['attachment'] = "<img src=" . $path_female . " class='rounded' width=110px height=140px alt='Famale' title='Female Employee'> <img border='0' class='shadow-driver' src='assets/images/shadow.jpg'>";
                        }
                    }
                }

                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }

        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'addEmployeeMini', 'view', 'html'));
    }

}

?>