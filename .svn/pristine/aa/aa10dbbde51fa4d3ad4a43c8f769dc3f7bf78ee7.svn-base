<?php

/**
 * @author Prima Noor
 */
class Process {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->Obj = GtfwDispt()->load->business('CoreMenu');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $result = true;
        $post = $_POST->AsArray();
        $appId = GtfwCfg('application', 'application_id');

        $Val = GtfwDispt()->load->library('Validation', GtfwCfg('application', 'language'));

        $Val->set_rules('order', 'order', 'required');

        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $langList = $ObjLang->listLangCode();

        if (empty($post['is_system_menu'])) {
            $post['is_system_menu'] = 0;
        }
        $result = $Val->run();
        if ($result) {
            if (empty($post['dataId'])) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['parent'],
                    NULL,
                    $post['desc'],
                    $post['show'],
                    $post['icon_large'],
                    $post['icon'],
                    $post['icon_small'],
                    $post['order'],
                    $appId,
                    $post['view_model'],
                    $post['class'],
                    $post['is_system_menu'],
                    $this->user
                );
                $result = $this->Obj->addMenu($params);
                $menuId = $this->Obj->LastInsertId();
                if ($result) {
                    foreach ($langList as $lang) {
                        $params = array(
                            $menuId,
                            $lang['id'],
                            $post['menu'][$lang['id']],
                            $post['menu_desc'][$lang['id']],
                            $this->user
                        );
                        $result = $this->Obj->addMenuText($params);
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
                    $post['parent'],
                    $post['desc'],
                    $post['show'],
                    $post['icon_large'],
                    $post['icon'],
                    $post['icon_small'],
                    $post['order'],
                    $post['view_model'],
                    //$post['module'],
                    $post['class'],
                    $post['is_system_menu'],
                    $this->user,
                    $post['dataId']
                );
                $result = $this->Obj->edit($params);
                $menuId = $post['dataId'];
                if ($result) {
                    $result = $result && $this->Obj->deleteMenuText($post['dataId']);
                    foreach ($langList as $lang) {
                        $params = array(
                            $menuId,
                            $lang['id'],
                            $post['menu'][$lang['id']],
                            $post['menu_desc'][$lang['id']],
                            $this->user
                        );
                        $result = $result && $this->Obj->addMenuText($params);
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
            $result = false;
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }

        if ($result) {
            Messenger::Instance()->Send('core.menu', 'menuList', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        } else {
            Messenger::Instance()->Send('core.menu', 'input', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
        }

        return $result;
    }

    function delete($id) {
        $result = $this->Obj->deleteMenu($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('core.menu', 'menuList', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>