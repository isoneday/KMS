<?php

/**
 * @author Prima Noor 
 */
class ViewKey extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_key.html');
    }

    function ProcessRequest() {
        $ObjKey = GtfwDispt()->load->business('Key', 'core.lang.key');
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

        Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);

        $data = $ObjKey->getKey($filter);
        $total = $ObjKey->countKey();

        $lang_data = $ObjKey->getLang();
        $lang_temp = $ObjKey->getKeyText();

        foreach ($lang_temp as $key => $val) {
            $lang[$val['id']]['text'][] = $val['translate'];
        }

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

        return compact('data', 'message', 'filter', 'jml', 'lang', 'lang_data');
    }

    function ParseTemplate($rdata = null) {
        $this->ButtonRendering();
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl() . '&display');
        if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }

        $this->mrTemplate->addVar('content', 'JML_LANG', count($lang_data));

        if (!empty($lang_data)) {
            foreach ($lang_data as $val) {
                $this->mrTemplate->addVars('lang', $val);
                $this->mrTemplate->parseTemplate('lang', 'a');
            }
        }

        if (!empty($data) and count($data) > 0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = $filter['start'] + 1;
            foreach ($data as $val) {
                $val['no'] = $no;
                $val['row_class'] = $no % 2 == 0 ? 'even' : 'odd';

                $val['url_detail'] = GtfwDispt()->GetUrl('core.lang.key', 'detailKey', 'view', 'html') . '&id=' . $val['id'];

                $this->mrTemplate->clearTemplate('button_update');
                $this->mrTemplate->addVar('button_update', 'URL', GtfwDispt()->GetUrl('core.lang.key', 'updateKey', 'view', 'html') . '&id=' . $val['id']);

                $this->mrTemplate->clearTemplate('button_delete');
                $this->mrTemplate->addVar('button_delete', 'NAME', $val['code']);
                $this->mrTemplate->addVar('button_delete', 'URL', GtfwDispt()->GetUrl('core.lang.key', 'deleteKey', 'do', 'json') . '&id=' . $val['id']);

                foreach ($lang[$val['id']]['text'] as $lang_val) {
                    $lang_pass['TRANSLATE'] = $lang_val;
                    $this->mrTemplate->addVars('lang_key', $lang_pass);
                    $this->mrTemplate->parseTemplate('lang_key', 'a');
                }


                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $this->mrTemplate->clearTemplate('lang_key');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }

        $this->mrTemplate->addVar('button_add', 'URL', GtfwDispt()->GetUrl('core.lang.key', 'addKey', 'view', 'html'));
    }

}

?>