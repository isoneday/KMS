<?php

/**
 * @author Prima Noor 
 */
class ViewStatus extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_status.html');
    }

    function ProcessRequest() {
        $ObjStatus = GtfwDispt()->load->business('RefEmpStatus', 'emp.ref.employee.status');
        $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');

        $msg = Messenger::Instance()->Receive(__FILE__);
        $filter_data = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[1][1]) ? $msg[1][1] : NULL;
        $message['style'] = isset($msg[1][2]) ? $msg[1][2] : NULL;

        if (!isset($_GET['display']) || empty($filter_data)) {
            $page = 1;
            $start = 0;
            $display = $ObjSetting->getValue('view_per_page');
            $filter = compact('page', 'display', 'start');
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
        if (!empty($post_data)) {
            foreach ($post_data as $key => $value)
                $filter[$key] = $value;
            $filter['start'] = 0;
            $filter['page'] = $page = 1;
        }
                Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);
        
        $data = $ObjStatus->getStatus($filter);
		$total = $ObjStatus->countStatus($filter);

        $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
        Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
        Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);

        return compact('data', 'message', 'filter');
    }

    function ParseTemplate($rdata = NULL) {
        $this->ButtonRendering();
        extract($rdata);
		
		$this->mrTemplate->addGlobalVar('lang_module', GtfwLangText('employee_status'));

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl().'&display');
        if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }

        if (!empty($data) AND count($data) > 0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = $filter['start'] + 1;
            foreach ($data as $val) {
                $val['no'] = $no;
                $val['url_detail'] = GtfwDispt()->GetUrl('emp.ref.employee.status', 'detailStatus', 'view', 'html') . '&id=' . Dispatcher::Instance()->Encrypt($val['id']);
                $val['status'] == 1 ? $val['status'] = GtfwLangText('active') : $val['status'] = GtfwLangText('not_active');
                $val['is_active'] == 1 ? $val['is_active'] = GtfwLangText('yes') : $val['is_active'] = GtfwLangText('no');

                $this->mrTemplate->clearTemplate('button_update');
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('emp.ref.employee.status', 'updateStatus', 'view', 'html') . '&id=' . Dispatcher::Instance()->Encrypt($val['id']));

                $this->mrTemplate->clearTemplate('button_delete');
                $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
                $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('emp.ref.employee.status', 'deleteStatus', 'do', 'json') . '&id=' . Dispatcher::Instance()->Encrypt($val['id']));

                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }

        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('emp.ref.employee.status', 'addStatus', 'view', 'html'));
    }

}

?>