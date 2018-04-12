<?php

/**
 * @author Prima Noor 
 */
class ViewMenuList extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_menu.html');
    }

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CoreMenu', 'core.menu');
        $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');

        $msg = Messenger::Instance()->Receive(__file__);
        $filter_data = isset($msg[0][0]) ? $msg[0][0] : null;

        $message['content'] = !empty($msg[1][1]) ? $msg[1][1] : null;
        $message['class'] = !empty($msg[1][2]) ? $msg[1][2] : null;

        if (empty($_GET['display']) || empty($filter_data)) {
            $page = 1;
            $start = 0;
            $lang = GtfwLang()->GetLangCode();
            $display = $ObjSetting->getValue('view_per_page');
            $filter = compact('page', 'display', 'start', 'lang');
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

        $data = $Obj->getData($filter);
        $total = $Obj->countData();

        Messenger::Instance()->SendToComponent('core.menu', 'comboMenu', 'view', 'html', 'parent', array('dataId' => (!empty($filter['parent']) ? $filter['parent'] : null), 'elmId' => 's_parent', 'name' => 'parent', 'first' => 'select'), Messenger::CurrentRequest);

        $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
        Messenger::Instance()->SendToComponent('comp.paging', 'paging', 'view', 'html', 'paging_top', array(
            $display,
            $total,
            $url,
            $page), Messenger::CurrentRequest);
        Messenger::Instance()->SendToComponent('comp.paging', 'paging', 'view', 'html', 'paging_bottom', array(
            $display,
            $total,
            $url,
            $page), Messenger::CurrentRequest);


        return compact('data', 'message', 'filter');
    }

    function ParseTemplate($rdata = null) {
        $this->ButtonRendering();
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('data_pesan', $message);
        }

        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl() . '&display');
        if ($filter) {
            $this->mrTemplate->addVars('search', $filter);
        }

        if (!empty($data)) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = (!isset($filter['start']) ? 0 : $filter['start']) + 1;
            foreach ($data as $val) {
                $val['no'] = $no;
                $val['row_class'] = $no % 2 == 0 ? 'even' : 'odd';

                $this->mrTemplate->clearTemplate('button_update');
                $url = GtfwDispt()->GetUrl('core.menu', 'updateMenu', 'view', 'html') . '&dataId=' . $val['dataId'];
                $this->mrTemplate->addVar('button_update', 'url', $url);

                $this->mrTemplate->clearTemplate('button_delete');
                $url = GtfwDispt()->GetUrl('core.menu', 'deleteMenu', 'do', 'json') . '&dataId=' . $val['dataId'];
                $this->mrTemplate->addVar('button_delete', 'NAME', $val['menu_name']);
                $this->mrTemplate->addVar('button_delete', 'URL', $url);

                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }

        $this->mrTemplate->addVar('button_add', 'URL_ADD', GtfwDispt()->GetUrl('core.menu', 'addMenu', 'view', 'html'));
    }

}

?>