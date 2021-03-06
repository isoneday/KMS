<?php

/**
 * @author Prima Noor
 */
class ProcessGroup {

    var $Obj;
    var $user;
    var $appId;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->Obj = GtfwDispt()->load->business('Group');
        $this->appId = GtfwCfg('application', 'application_id');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();

        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('name', 'name', 'required');

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {

                $this->Obj->StartTrans();
                $params = array(
                    $post['name'],
                    $this->appId,
                    $post['description'],
                    $this->user
                );
                if ($result)
                    $result = $this->Obj->insertGroup($params);

                if ($result AND !empty($post['access'])) {
                    $groupId = $this->Obj->LastInsertId();

                    # hard code, add module home
                    $params = array(
                        $groupId,
                        0
                    );
                    if ($result)
                        $result = $this->Obj->insertGroupMenu($params);
                    if ($result)
                        $result = $this->Obj->insertGroupModuleByMenu($params);

                    $access = explode(',', $post['access']);
                    foreach ($access as $val) {
                        $params = array(
                            $groupId,
                            $val
                        );
                        # insert into group_menu
                        if ($result)
                            $result = $this->Obj->insertGroupMenu($params);
                        # insert into group_module by menu_id
                        $params = array(
                            'group_id' => $groupId,
                            'menu_id' => $val,
                            'actions' => !empty($post['action'][$val]) ? implode(',', $post['action'][$val]) : ''
                        );
                        if ($result)
                            $result = $this->Obj->insertGroupModuleByMenu($params);
                    }
                }
                $this->Obj->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->Obj->StartTrans();
                $params = array(
                    $post['name'],
                    $this->appId,
                    $post['description'],
                    $this->user,
                    $post['id']
                );
                if ($result)
                    $result = $this->Obj->updateGroup($params);

                if ($result AND !empty($post['access'])) {
                    $groupId = $post['id'];
                    if ($result)
                        $result = $this->Obj->deleteGroupMenu($groupId);
                    if ($result)
                        $result = $this->Obj->deleteGroupModule($groupId);

                    # hard code, add module home
                    $params = array(
                        'group_id' => $groupId,
                        'menu_id' => 0
                    );
                    if ($result)
                        $result = $this->Obj->insertGroupMenu($params);
                    if ($result)
                        $result = $this->Obj->insertGroupModuleByMenu($params);

                    $access = explode(',', $post['access']);
                    foreach ($access as $val) {
                        $params = array(
                            $groupId,
                            $val
                        );
                        # insert into group_menu
                        if ($result)
                            $result = $this->Obj->insertGroupMenu($params);
                        # insert into group_module by menu_id
                        $params = array(
                            'group_id' => $groupId,
                            'menu_id' => $val,
                            'actions' => !empty($post['action'][$val]) ? implode(',', $post['action'][$val]) : ''
                        );
                        if ($result)
                            $result = $this->Obj->insertGroupModuleByMenu($params);
                    }
                }
                $this->Obj->EndTrans($result);

                if ($result) {
                    $msg = GtfwLangText('msg_update_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_update_fail');
                    $css = $this->cssFail;
                }
            }
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }
        if ($result) {
            Messenger::Instance()->Send('core.group', 'group', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.group', 'group', 'view', 'html');
        } else {
            Messenger::Instance()->Send('core.group', 'inputGroup', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.group', (empty($post['id'])?'add':'update').'Group', 'view', 'html');
        }

        return $result;
    }

    function delete($id) {
        $result = false;
        $msg = '';
        if (!$this->Obj->checkGroupUsed($id)) {
            $result = true;

            if ($result)
                $result = $this->Obj->deleteGroupMenu($id);
            if ($result)
                $result = $this->Obj->deleteGroupModule($id);
            if ($result)
                $result = $this->Obj->deleteGroup($id);
        } else {
            $msg .= GtfwLangText('group_used') . '<br />';
            $css = $this->cssFail;
        }

        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg .= GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('core.group', 'group', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        return $result;
    }

}

?>