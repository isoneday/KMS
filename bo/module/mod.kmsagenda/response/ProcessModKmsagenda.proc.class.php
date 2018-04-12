<?php
/**
 * @author Prima Noor
 */
 
class ProcessModKmsagenda
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjModKmsagenda = GtfwDispt()->load->business('ModKmsagenda');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('judul', GtfwLangText('judul'), 'required');
        $Val->set_rules('desc', GtfwLangText('desc'), 'required');
        $Val->set_rules('status', GtfwLangText('status'), 'required');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKmsagenda->StartTrans();
                $params = array(
                    $this->user,
                    $post['judul'],
                    $post['desc'],
                     $post['status']
                    
                      
                );
                $result = $result && $this->ObjModKmsagenda->insertModKmsagenda($params);
                $this->ObjModKmsagenda->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjModKmsagenda->StartTrans();
                $params = array(
                    $post['judul'],
                    $post['desc'],
                    $post['status'],
                    $post['id']
                );
                $result = $result && $this->ObjModKmsagenda->updateModKmsagenda($params);
                $this->ObjModKmsagenda->EndTrans($result);   
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
            Messenger::Instance()->Send('mod.kmsagenda', 'ModKmsagenda', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsagenda', 'modkmsagenda', 'view', 'html');
        } else {
            Messenger::Instance()->Send('mod.kmsagenda', 'inputModKmsagenda', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsagenda', (empty($post['id'])?'add':'update').'ModKmsagenda', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjModKmsagenda->deleteModKmsagenda($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kmsagenda', 'ModKmsagenda', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>