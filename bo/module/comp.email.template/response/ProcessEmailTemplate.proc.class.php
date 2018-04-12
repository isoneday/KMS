<?php

/**
 * @author Prima Noor
 */
class ProcessEmailTemplate {

    var $Obj;
    var $user;
    var $ObjEmailTemplate;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjEmailTemplate = GtfwDispt()->load->business('EmailTemplate', 'comp.email.template');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $ObjLang = GtfwDispt()->load->business('Language', 'core.language');
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('purpose', GtfwLangText('purpose'), 'required');
        $Val->set_rules('subject', GtfwLangText('subject'), 'required');
        $Val->set_rules('from', GtfwLangText('from'), 'required');

        $langList = $ObjLang->listLangCode();

        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjEmailTemplate->StartTrans();
                $params = array(
                    $post['purpose'],
                    $post['subject'],
                    $post['from'],
                    $post['from_name'],
                    $post['attachment'],
                    $post['param'],
                    $this->user
                );
                $result = $result && $this->ObjEmailTemplate->insertEmailTemplate($params);
                $template_id = $this->ObjEmailTemplate->LastInsertId();

                if ($result) {
                    if (isset($post['body']) || isset($post['alt_body'])) {
                        foreach ($langList as $key => $lang) {
                            $params = array(
                                $template_id,
                                $lang['id'],
                                $post['body'][$lang['id']],
                                $post['alt_body'][$lang['id']],
                                $this->user
                            );
                            $result = $this->ObjEmailTemplate->insertEmailTemplateText($params);
                        }
                    }
                }

                $this->ObjEmailTemplate->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjEmailTemplate->StartTrans();
                $params = array(
                    $post['purpose'],
                    $post['subject'],
                    $post['from'],
                    $post['from_name'],
                    $post['attachment'],
                    $post['param'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjEmailTemplate->updateEmailTemplate($params);
                if ($result) {
                    $result = $result && $this->ObjEmailTemplate->deleteEmailTemplateText($post['id']);
                    foreach ($langList as $key => $lang) {
                        $params = array(
                            $post['id'],
                            $lang['id'],
                            $post['body'][$lang['id']],
                            $post['alt_body'][$lang['id']],
                            $this->user
                        );
                        $result = $result && $this->ObjEmailTemplate->insertEmailTemplateText($params);
                    }
                }
                $this->ObjEmailTemplate->EndTrans($result);
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
            Messenger::Instance()->Send('comp.email.template', 'EmailTemplate', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('comp.email.template', 'emailtemplate', 'view', 'html');
        } else {
            Messenger::Instance()->Send('comp.email.template', 'inputEmailTemplate', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('comp.email.template', (empty($post['id'])?'add':'update').'EmailTemplate', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = true;
        $this->ObjEmailTemplate->StartTrans();
        $result = $this->ObjEmailTemplate->deleteEmailTemplateText($id);
        $result = $result && $this->ObjEmailTemplate->deleteEmailTemplate($id);
        $this->ObjEmailTemplate->EndTrans($result);

        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('comp.email.template', 'EmailTemplate', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }

    public function send_mail_notification($address, $mesg, $subjek = '') {
        $objMail = GtfwDispt()->load->library('PHPMailer');
        $message = $this->template_email($mesg, $subjek);
        $objMail->sentEmail($address, $subjek, $message);
    }

    function template_email($content, $subjek) {
        $template = '<html>
    <head>
    </head>
    <body>
        <table style="background: none repeat scroll 0% 0% #6db3f2; width: 600px; padding: 15px;" align=center>
            <tr>
                <td width="100%">				
                    <table style="background-color: #fff; width: 600px; padding: 15px;" align="center">
                        <tr>
                            <td>
                                <table style="background-color: #fff; width: 600px;" align="center">
                                    <tr>
                                        <td width="200px"><img src="../../images/logo_small.png" width="150px" /></td>
                                        <td width="400px"></td>
                                    </tr>
                                </table><hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999;" />								
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="background-color: #fff; width: 600px;" align="center">
                                    <tr>
                                        <td>							
                                            <p style="font-family: "Open Sans",Verdana,Arial,Helvetica,sans-serif;
                                               font-weight: normal;
                                               font-size: 12px;
                                               line-height: 1.6;
                                               margin-bottom: 1.25em;
                                               text-rendering: optimizelegibility;">' . $subjek . '.<br /><br />';

        $template .= $content . '<p>		
                                        </td>
                                    </tr>
                                </table>								
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table style="background-color: #ededed; width: 600px; text-align: center;" align="center">
                                    <tr>
                                        <td>							
                                            <p>
                                                Copyright &copy; 2016 <a href="' . Configuration::Instance()->GetValue('application', 'baseaddress') . '">Beasiswa Pertamina Foundation</a><br />
                                                Jl. Sinabung II, Terusan Simprug Raya, Kawasan Pertamina Learning Centre Simprug, Jakarta Selatan 12220
                                            <p>		
                                        </td>
                                    </tr>
                                </table>								
                            </td>
                        </tr>
                    </table>
                    </body>
            <html>';

        return $template;
    }

}

?>