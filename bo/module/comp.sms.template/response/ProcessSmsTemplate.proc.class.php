<?php

/**
 * @author Prima Noor
 */
class ProcessSmsTemplate {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjSmsTemplate = GtfwDispt()->load->business('SmsTemplate');
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
                $this->ObjSmsTemplate->StartTrans();
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
                $result = $result && $this->ObjSmsTemplate->insertSmsTemplate($params);
                $sms_id = $this->ObjSmsTemplate->LastInsertId();
                if ($result) {
                    if (isset($post['body'])) {
                        foreach ($langList as $key => $lang) {
                            $params = array(
                                $sms_id,
                                $lang['id'],
                                $post['body'][$lang['id']],
                                $this->user
                            );
                            $result = $this->ObjSmsTemplate->insertSmsTemplateText($params);
                        }
                    }
                }

                $this->ObjSmsTemplate->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjSmsTemplate->StartTrans();
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
                $result = $result && $this->ObjSmsTemplate->updateSmsTemplate($params);
                if ($result) {
                    $result = $result && $this->ObjSmsTemplate->deleteSmsTemplateText($post['id']);
                    foreach ($langList as $key => $lang) {
                        $params = array(
                            $post['id'],
                            $lang['id'],
                            $post['body'][$lang['id']],
                            $this->user
                        );
                        $result = $result && $this->ObjSmsTemplate->insertSmsTemplateText($params);
                    }
                }
                $this->ObjSmsTemplate->EndTrans($result);
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
            Messenger::Instance()->Send('comp.sms.template', 'SmsTemplate', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('comp.sms.template', 'smstemplate', 'view', 'html');
        } else {
            Messenger::Instance()->Send('comp.sms.template', 'inputSmsTemplate', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('comp.sms.template', (empty($post['id'])?'add':'update').'SmsTemplate', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = true;
        $this->ObjSmsTemplate->StartTrans();
        $result = $this->ObjSmsTemplate->deleteSmsTemplateText($id);
        $result = $result && $this->ObjSmsTemplate->deleteSmsTemplate($id);
        $this->ObjSmsTemplate->EndTrans($result);

        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('comp.sms.template', 'SmsTemplate', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

}

?>