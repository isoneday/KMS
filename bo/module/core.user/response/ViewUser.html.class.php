<?php

/**
 * @author Prima Noor 
 */

class ViewUser extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_user.html');
    }

    function ProcessRequest()
    {
        $ObjUser = GtfwDispt()->load->business('User', 'core.user');
        $ObjGroup = GtfwDispt()->load->business('Group', 'core.group');
        $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');

        $msg = Messenger::Instance()->Receive(__file__);
        $filter_data = isset($msg[0][0]) ? $msg[0][0] : null;
        $message['content'] = isset($msg[1][1]) ? $msg[1][1] : null;
        $message['style'] = isset($msg[1][2]) ? $msg[1][2] : null;

        if (!isset($_GET['display']) || empty($filter_data)) {
            $page = 1;
            $start = 0;
            $display = $ObjSetting->getValue('view_per_page');
            $filter = compact('page', 'display', 'start');
        } elseif ($_GET['display']->Raw() != '') {
            $page = (int)$_GET['page']->SqlString()->Raw();
            $display = (int)$_GET['display']->SqlString()->Raw();

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

        $total = $ObjUser->countUser($filter);
        $data = $ObjUser->getUser($filter);

        $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
        Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array(
            $display,
            $total,
            $url,
            $page), Messenger::CurrentRequest);
        Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_bottom', array(
            $display,
            $total,
            $url,
            $page), Messenger::CurrentRequest);

        $listGroup = $ObjGroup->listGroup();
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'group', array(
            'group',
            $listGroup,
            !empty($filter['group'])?$filter['group']:'',
            'true',
            ' style=""'), Messenger::CurrentRequest);
Messenger::Instance()->SendToComponent('emp.ref.employee.type', 'comboRefEmpType', 'view', 'html', 'type_id', array(
            'dataId' => (!empty($filter['type_id']) ? $filter['type_id'] : null),
            'elmId' => 'type_id',
            'first' => 'all',
            'showAdd' => false,
            'name' => 'type_id',
            'style' => '',
            'script' => ''), Messenger::CurrentRequest);

     
        return compact('data', 'message', 'filter');
    }

    function ParseTemplate($rdata = null)
    {
        $this->ButtonRendering();
        extract($rdata);
        //     echo "<pre>";
      //print_r($data);
     //   print_r($filter);
     // //   die();
    
                

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl().'&display');
        if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }

        if (!empty($data) and count($data) > 0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = $filter['start'] + 1;
            $allowDetail = Security::Authorization()->IsAllowedToAccess('core.group', 'detailGroup', 'view', 'html');
            foreach ($data as $val) {
                                     if($val['active'] =='1'){
                      $val['active']="active";
                     }
                     else{
                      $val['active']="not active";
                        
                     }

                $val['no'] = $no;
                $val['url_detail'] = GtfwDispt()->GetUrl('core.user', 'detailUser', 'view', 'html') . '&id=' . $val['id'];

                if (!empty($val['group'])) {
                    $groups = explode(',', $val['group']);
                    $group = array();
                    foreach ($groups as $value) {
                        $tmp = explode('|', $value);
                        $group[] = array('id' => $tmp[0], 'name' => $tmp[1]);
                    }
                    
                    if ($allowDetail) {
                        $this->mrTemplate->addVar('group', 'ALLOW_DETAIL', 'YES');
                        $title = GtfwLangText('detail') . ' ' . GtfwLangText('group');
                        $this->mrTemplate->clearTemplate('item_group_anchor');
                        foreach ($group as $value) {
                            $dataGroup = array();
                            $dataGroup['url'] = GtfwDispt()->GetUrl('core.group', 'detailGroup', 'view', 'html') . '&id=' . $value['id'];
                            $dataGroup['group'] = $value['name'];
                            $dataGroup['title'] = $title;
                            $this->mrTemplate->addVars('item_group_anchor', $dataGroup);
                            $this->mrTemplate->parseTemplate('item_group_anchor', 'a');
                        }
                    } else {
                        $this->mrTemplate->addVar('group', 'ALLOW_DETAIL', 'NO');
                        //$groups = array();
                        $this->mrTemplate->clearTemplate('item_group_no_anchor');
                        foreach ($group as $value) {
                            //$groups[] = $value['name'];
                            $this->mrTemplate->addVar('item_group_no_anchor', 'GROUP', $value['name']);
                            $this->mrTemplate->parseTemplate('item_group_no_anchor', 'a');
                        }
                        //$this->mrTemplate->addVar('group', 'GROUPS', implode(', ', $groups));
                    }
                }

                $this->mrTemplate->clearTemplate('button_update');
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('core.user', 'updateUser', 'view', 'html') . '&id=' . $val['id']);

                $this->mrTemplate->clearTemplate('button_delete');
                $this->mrTemplate->addVar('button_delete', 'NAME', $val['name']);
                $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('core.user', 'deleteUser', 'do', 'json') . '&id=' . $val['id']);

                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }

        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('core.user', 'addUser', 'view', 'html'));
    }
}

?>