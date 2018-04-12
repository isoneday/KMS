<?php
/**
 * @author Prima Noor
 */
 
class ProcessCmsFaq
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjCmsFaq = GtfwDispt()->load->business('CmsFaq');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjCmsFaq->StartTrans();
                $params = array(
                    $post['question'],
                    $post['answer'],
                    $this->user
                );
                $result = $result && $this->ObjCmsFaq->insertCmsFaq($params);
                $this->ObjCmsFaq->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjCmsFaq->StartTrans();
                $params = array(
                    $post['question'],
                    $post['answer'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjCmsFaq->updateCmsFaq($params);
                $this->ObjCmsFaq->EndTrans($result);   
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
            Messenger::Instance()->Send('cms.faq', 'CmsFaq', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.faq', 'cmsfaq', 'view', 'html');
        } else {
            Messenger::Instance()->Send('cms.faq', 'inputCmsFaq', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.faq', (empty($post['id'])?'add':'update').'CmsFaq', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjCmsFaq->deleteCmsFaq($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('cms.faq', 'CmsFaq', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>