<?php

/**
 * @author Prima Noor 
 */
class ViewDetailCoreUserall extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_coreuserall.html');
    }

    function ProcessRequest() {
        $ObjCoreUserall = GtfwDispt()->load->business('CoreUserall', 'core.userall');
        $ObjGroup = GtfwDispt()->load->business('CoreGroupall', 'core.groupall');

        $id = $_GET['id']->Integer()->Raw();

        $detail = $ObjCoreUserall->getDetailCoreUserall($id);
        if (!empty($detail)) {
            $detail['group'] = explode(',', $detail['group']);
        }

        $list_app = $ObjGroup->listApplication();
        foreach ($list_app as $key => $val) {
            $list_app[$key]['list_group'] = $ObjGroup->listGroup($val['id']);
        }

        return compact('detail', 'list_app');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($list_app)) {
            $title = GtfwLangText('detail');
            $allowDetail = Security::Authorization()->IsAllowedToAccess('core.group', 'detailGroup', 'view', 'html');

            for ($i = 0; $i < sizeof($list_app); $i++) {
                $list_group = $list_app[$i]['list_group'];
                unset($list_app[$i]['list_group']);
                $this->mrTemplate->addVars('group', $list_app[$i]);
                $this->mrTemplate->clearTemplate('item');

                if (!empty($list_group)) {
                    foreach ($list_group as $key => $value) {
                        $dataGroup = array();
                        $dataGroup['name'] = $value['name'];
                        $dataGroup['id'] = $value['id'];
                        if ($allowDetail) {
                            $dataGroup['title'] = $title;
                            $dataGroup['url_group'] = GtfwDispt()->GetUrl('core.groupall', 'detailCoreGroupall', 'view', 'html') . '&id=' . $value['id'] . '&appId=' . $value['application_id'];
                        }
                        if (!empty($detail['group']) && in_array($value['id'], $detail['group'])) {
                            $dataGroup['img'] = '<span class=icon-ok></span>';
                            $dataGroup['group_name'] = "<b><a class='popup_group_detail' href='" . $dataGroup['url_group'] . "' title=" . GtfwLangText('detail_group') . ">" . $dataGroup['name'] . "</a></b>";
                        } else {
                            $dataGroup['img'] = '<span class=icon-minus-sign></span>';
                            $dataGroup['group_name'] = '<span style="color : grey;">' . $dataGroup['name'] . '</span>';
                        }

                        $this->mrTemplate->addVars('item', $dataGroup);
                        $this->mrTemplate->parseTemplate('item', 'a');
                    }
                }
                $this->mrTemplate->parseTemplate('group', 'a');
            }
        }

        if (!empty($detail)) {
            if (!empty($detail['group']))
                unset($detail['group']);
            $this->mrTemplate->addVars('content', $detail);
        }
    }

}

?>