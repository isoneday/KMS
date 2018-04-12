<?php
/**
 * @author Prima Noor
 */
 
class ProcessTermCondition
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjTermCondition = GtfwDispt()->load->business('TermCondition');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjTermCondition->StartTrans();
                $params = array(
                    $post['title'],
                    $post['content'],
                    $this->user
                );
                $result = $result && $this->ObjTermCondition->insertTermCondition($params);
                $this->ObjTermCondition->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjTermCondition->StartTrans();
                $params = array(
                    $post['title'],
                    $post['content'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjTermCondition->updateTermCondition($params);
                $this->ObjTermCondition->EndTrans($result);   
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
            Messenger::Instance()->Send('cms.term.condition', 'TermCondition', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.term.condition', 'termcondition', 'view', 'html');
        } else {
            Messenger::Instance()->Send('cms.term.condition', 'inputTermCondition', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.term.condition', (empty($post['id'])?'add':'update').'TermCondition', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjTermCondition->deleteTermCondition($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('cms.term.condition', 'TermCondition', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>