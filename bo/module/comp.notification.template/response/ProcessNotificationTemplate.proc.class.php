<?php

/**
 * @author Prima Noor
 */
class ProcessNotificationTemplate {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjNotificationTemplate = GtfwDispt()->load->business('NotificationTemplate');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('purpose', GtfwLangText('purpose'), 'required');
        $Val->set_rules('subject', GtfwLangText('subject'), 'required');

        $langList = $ObjLang->listLangCode();

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjNotificationTemplate->StartTrans();
                $params = array(
                    $post['purpose'],
                    $post['subject'],
                    $post['param'],
                    $post['url_notif'],
                    1,
                    '',
                    1,
                    $this->user
                );
                $result = $result && $this->ObjNotificationTemplate->insertNotificationTemplate($params);
                $notif_id = $this->ObjNotificationTemplate->LastInsertId();

                if ($result) {
                    if (isset($post['body']) || isset($post['alt_body'])) {
                        foreach ($langList as $key => $lang) {
                            $params = array(
                                $notif_id,
                                $lang['id'],
                                $post['body'][$lang['id']],
                                $post['alt_body'][$lang['id']],
                                $this->user
                            );
                            $result = $this->ObjNotificationTemplate->insertNotificationTemplateText($params);
                        }
                    }
                }

                $this->ObjNotificationTemplate->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjNotificationTemplate->StartTrans();
                $params = array(
                    $post['purpose'],
                    $post['subject'],
                    $post['param'],
                    $post['url_notif'],
                    1,
                    '',
                    '1',
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjNotificationTemplate->updateNotificationTemplate($params);
                if ($result) {
                    $result = $result && $this->ObjNotificationTemplate->deleteNotificationTemplateText($post['id']);
                    foreach ($langList as $key => $lang) {
                        $params = array(
                            $post['id'],
                            $lang['id'],
                            $post['body'][$lang['id']],
                            $post['alt_body'][$lang['id']],
                            $this->user
                        );
                        $result = $result && $this->ObjNotificationTemplate->insertNotificationTemplateText($params);
                    }
                }

                $this->ObjNotificationTemplate->EndTrans($result);
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
            Messenger::Instance()->Send('comp.notification.template', 'NotificationTemplate', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('comp.notification.template', 'notificationtemplate', 'view', 'html');
        } else {
            Messenger::Instance()->Send('comp.notification.template', 'inputNotificationTemplate', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('comp.notification.template', (empty($post['id'])?'add':'update').'NotificationTemplate', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = true;
        $this->ObjNotificationTemplate->StartTrans();
        $result = $this->ObjNotificationTemplate->deleteNotificationTemplateText($id);
        $result = $result && $this->ObjNotificationTemplate->deleteNotificationTemplate($id);
        $this->ObjNotificationTemplate->EndTrans($result);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('comp.notification.template', 'NotificationTemplate', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>