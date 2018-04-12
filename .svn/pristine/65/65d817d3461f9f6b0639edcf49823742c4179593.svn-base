<?php

/**
 * @author Prima Noor
 */
class ProcessCoreGroupall {

    var $Obj;
    var $user;
    var $appId;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjCoreGroupall = GtfwDispt()->load->business('CoreGroupall');
        $this->appId = GtfwCfg('application', 'application_id');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('name', GtfwLangText('name'), 'required');

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjCoreGroupall->StartTrans();
                $params = array(
                    $post['name'],
                    $post['desc'],
                    $post['application_id'],
                    $this->user
                );
                $result = $result && $this->ObjCoreGroupall->insertCoreGroupall($params);
                if ($result && !empty($post['access'])) {
                    $groupId = $this->ObjCoreGroupall->LastInsertId();

                    # hard code, add module home
                    $params = array(
                        $groupId,
                        0
                    );
                    if ($result)
                        $result = $this->ObjCoreGroupall->insertGroupMenu($params);
                    if ($result)
                        $result = $this->ObjCoreGroupall->insertGroupModuleByMenu($params);

                    $access = explode(',', $post['access']);
                    foreach ($access as $val) {
                        $params = array(
                            $groupId,
                            $val
                        );
                        # insert into group_menu
                        if ($result)
                            $result = $this->ObjCoreGroupall->insertGroupMenu($params);
                        # insert into group_module by menu_id
                        $params = array(
                            'group_id' => $groupId,
                            'menu_id' => $val,
                            'actions' => !empty($post['action'][$val]) ? implode(',', $post['action'][$val]) : ''
                        );
                        if ($result)
                            $result = $this->ObjCoreGroupall->insertGroupModuleByMenu($params);
                    }
                }
                $this->ObjCoreGroupall->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjCoreGroupall->StartTrans();
                $params = array(
                    $post['name'],
                    $post['desc'],
                    $post['application_id'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjCoreGroupall->updateCoreGroupall($params);

                if ($result && !empty($post['access'])) {
                    $groupId = $post['id'];
                    if ($result)
                        $result = $this->ObjCoreGroupall->deleteGroupMenu($groupId);
                    if ($result)
                        $result = $this->ObjCoreGroupall->deleteGroupModule($groupId);

                    # hard code, add module home
                    $params = array(
                        'group_id' => $groupId,
                        'menu_id' => 0
                    );
                    if ($result)
                        $result = $this->ObjCoreGroupall->insertGroupMenu($params);
                    if ($result)
                        $result = $this->ObjCoreGroupall->insertGroupModuleByMenu($params);

                    $access = explode(',', $post['access']);
                    foreach ($access as $val) {
                        $params = array(
                            $groupId,
                            $val
                        );
                        # insert into group_menu
                        if ($result)
                            $result = $this->ObjCoreGroupall->insertGroupMenu($params);
                        # insert into group_module by menu_id
                        $params = array(
                            'group_id' => $groupId,
                            'menu_id' => $val,
                            'actions' => !empty($post['action'][$val]) ? implode(',', $post['action'][$val]) : ''
                        );
                        if ($result)
                            $result = $this->ObjCoreGroupall->insertGroupModuleByMenu($params);
                    }
                }
                $this->ObjCoreGroupall->EndTrans($result);
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
            Messenger::Instance()->Send('core.groupall', 'CoreGroupall', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        } else {
            Messenger::Instance()->Send('core.groupall', 'inputCoreGroupall', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
        }
        return $result;
    }

    function delete($id) {
        $result = false;
        $msg = '';
        if (!$this->ObjCoreGroupall->checkGroupUsed($id)) {
            $result = true;

            if ($result)
                $result = $this->ObjCoreGroupall->deleteGroupMenu($id);
            if ($result)
                $result = $this->ObjCoreGroupall->deleteGroupModule($id);
            if ($result)
                $result = $this->ObjCoreGroupall->deleteCoreGroupall($id);
        } else {
            $msg .= GtfwLangText('group_used') . '<br />';
            $css = $this->cssFail;
        }
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('core.groupall', 'CoreGroupall', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>