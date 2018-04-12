<?php
/**
 * @author Prima Noor
 */
 
class ProcessLegalInformation
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjLegalInformation = GtfwDispt()->load->business('LegalInformation');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjLegalInformation->StartTrans();
                $params = array(
                    $post['title'],
                    $post['content'],
                    $this->user
                );
                $result = $result && $this->ObjLegalInformation->insertLegalInformation($params);
                $this->ObjLegalInformation->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjLegalInformation->StartTrans();
                $params = array(
                    $post['title'],
                    $post['content'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjLegalInformation->updateLegalInformation($params);
                $this->ObjLegalInformation->EndTrans($result);   
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
            Messenger::Instance()->Send('cms.legal.information', 'LegalInformation', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.legal.information', 'legalinformation', 'view', 'html');
        } else {
            Messenger::Instance()->Send('cms.legal.information', 'inputLegalInformation', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.legal.information', (empty($post['id'])?'add':'update').'LegalInformation', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjLegalInformation->deleteLegalInformation($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('cms.legal.information', 'LegalInformation', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>