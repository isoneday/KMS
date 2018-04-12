<?php

/**
 * @author Prima Noor 
 */
class ViewHakAkses extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_hak_akses.html');
    }

    function ProcessRequest() {
        $ObjCoreGroupall = GtfwDispt()->load->business('CoreGroupall', 'core.groupall');

        $appId = $_GET['appId']->Integer()->Raw();
        $group_id = $_GET['grId']->Integer()->Raw();

        $msg = Messenger::Instance()->Receive(__file__);
        $post = isset($msg[0][0]) ? $msg[0][0] : null;

        $access = array();
        $action = array();
        if (!empty($post)) {
            if (!empty($post['access'])) {
                $acc = $post['access'];
                unset($post['access']);
                $access = explode(',', $acc);
            }
            if (!empty($post['action'])) {
                $action = $post['action'];
                unset($post['action']);
            }
            $input = $post;
        } elseif (!empty($group_id)) {
            $result = $ObjCoreGroupall->getAccessGroup($group_id);
            foreach ($result as $val) {
                $access[] = $val['menu_id'];
                $tmp = explode(',', $val['actions']);
                if (!empty($tmp)) {
                    foreach ($tmp as $act) {
                        $action[$val['menu_id']][$act] = $act;
                    }
                }
            }
        }

        $menuList = $ObjCoreGroupall->getMenuList($appId);
        $actionList = $ObjCoreGroupall->getActionList();

        if (!empty($menuList)) {
            $list = array();
            foreach ($menuList as $val) {
                $list[] = array(
                    'id' => $val['id'],
                    'parent_id' => $val['parent_id'],
                    'title' => $val['name'],
                    'action_id' => $val['action'],
                    'action_name' => (empty($val['action']) ? '' : (' <em>(' . $val['action_name'] . ')</em>')),
                    'link' => GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']),
                    'position' => $val['order']
                );
            }
        }
        if (!empty($list)) {
            $menu = $ObjCoreGroupall->getMenu($list, 0, $access, $action, $actionList);
        }
        return compact('menu');
    }

    function ParseTemplate($rdata = NULL) {
        if (is_array($rdata))
            extract($rdata);
        if (!empty($menu)) {
            $this->mrTemplate->addVar('content', 'menu', $menu);
        }
    }

}

?>