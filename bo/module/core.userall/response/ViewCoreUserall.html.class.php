<?php

/**
 * @author Prima Noor 
 */
class ViewCoreUserall extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_coreuserall.html');
    }

    function ProcessRequest() {
        $ObjCoreUserall = GtfwDispt()->load->business('CoreUserall', 'core.userall');
        $ObjGroup = GtfwDispt()->load->business('Group', 'core.group');
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
        if (isset($post_data))
            foreach ($post_data as $key => $value)
                $filter[$key] = $value;

        $listGroup = $ObjGroup->listGroup();
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'group', array(
            'group',
            $listGroup,
            !empty($filter['group']) ? $filter['group'] : '',
            'true',
            ' style=""'), Messenger::CurrentRequest);

        Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);

        $data = $ObjCoreUserall->getCoreUserall($filter);
        $total = $ObjCoreUserall->countCoreUserall();
        foreach ($data as $key => $value) {
            $data[$key]['group'] = $ObjCoreUserall->getUserGroup($value['id']);
        }

        $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
        Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
        Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array($display, $total, $url, $page), Messenger::CurrentRequest);

        return compact('data', 'message', 'filter');
    }

    function ParseTemplate($rdata = NULL) {
        $this->ButtonRendering();
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl() . '&display');
        if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }

        if (!empty($data) && count($data) > 0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = $filter['start'] + 1;
            foreach ($data as $key => $val) {
                $group = $data[$key]['group'];
                $rowspan = count($group);
                $allowDetail = Security::Authorization()->IsAllowedToAccess('core.groupall', 'detailCoreGroupall', 'view', 'html');

                if (!empty($group)) {
                    $this->mrTemplate->addVar('action', 'IS_EMPTY', 'YES');

                    foreach ($group as $key_value => $value) {
                        $value['url_group'] = GtfwDispt()->GetUrl('core.groupall', 'detailCoreGroupall', 'view', 'html') . '&id=' . $value['group_id']. '&appId=' . $value['application_id'];
                        $value['url_detail'] = GtfwDispt()->GetUrl('core.userall', 'detailCoreUserall', 'view', 'html') . '&id=' . $val['id'] ;
                        $this->mrTemplate->clearTemplate('button_update');
                        $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('core.userall', 'updateCoreUserall', 'view', 'html') . '&id=' . $val['id']);

                        $this->mrTemplate->clearTemplate('button_delete');
                        $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
                        $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('core.userall', 'deleteCoreUserall', 'do', 'json') . '&id=' . $val['id']);

                        if ($key_value < 1) {
                            $value['row_no'] = "
                            <td style=\"text-align: center;\" rowspan=" . $rowspan . ">" . $no . "</td>";
                            $value['rowspan'] = "rowspan=" . $rowspan . "";
                            $value['row_val'] = "
                            <td rowspan=" . $rowspan . ">" . $val['real_name'] . "</td>
                            <td rowspan=" . $rowspan . ">" . $val['name'] . "</td>
                            <td rowspan=" . $rowspan . ">" . $val['email'] . "</td>
                            ";
                        } else {
                            $value['row_no'] = "";
                            $value['rowspan'] = "";
                            $value['row_val'] = "";
                        }

                        if ($allowDetail) {
                            $value['group_name'] = "<a class='popup_group' href='" . $value['url_group'] . "' title=" . GtfwLangText('detail_group') . ">" . $value['group_name'] . "</a>";
                        } else {
                            $value['group_name'] = $value['group_name'];
                        }
                        $this->mrTemplate->addVar('action', 'rowspan', $value['rowspan']);
                        $this->mrTemplate->addVar('action', 'url_detail', $value['url_detail']);
                        $this->mrTemplate->addVars('item', $value);
                        $this->mrTemplate->parseTemplate('item', 'a');
                    }
                } else {
                    $val_emp['url_detail'] = GtfwDispt()->GetUrl('core.userall', 'detailCoreUserall', 'view', 'html') . '&id=' . $val['id'];
                    $this->mrTemplate->clearTemplate('button_update');
                    $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('core.userall', 'updateCoreUserall', 'view', 'html') . '&id=' . $val['id']);

                    $this->mrTemplate->clearTemplate('button_delete');
                    $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
                    $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('core.userall', 'deleteCoreUserall', 'do', 'json') . '&id=' . $val['id']);

                    $this->mrTemplate->addVar('action', 'IS_EMPTY', 'YES');
                    $val_emp['row_no'] = "
                            <td style=\"text-align: center;\">" . $no . "</td>";
                    $val_emp['row_val'] = "
                            <td>" . $data[$key]['real_name'] . "</td>
                            <td>" . $data[$key]['name'] . "</td>
                            <td>" . $data[$key]['email'] . "</td>
                            ";

                    $this->mrTemplate->addVar('item', 'ROW_NO', $val_emp['row_no']);
                    $this->mrTemplate->addVar('action', 'URL_DETAIL', $val_emp['url_detail']);
                    $this->mrTemplate->addVar('item', 'ROW_VAL', $val_emp['row_val']);
                    $this->mrTemplate->parseTemplate('item', 'a');
                }
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }

        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('core.userall', 'addCoreUserall', 'view', 'html'));
    }

}

?>