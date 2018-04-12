<?php
/**
 * @author Prima Noor
 */
 
class ProcessModKmsmanagereward
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjModKmsmanagereward = GtfwDispt()->load->business('ModKmsmanagereward');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('nama_reward', GtfwLangText('nama_reward'), 'required');
        $Val->set_rules('keterangan', GtfwLangText('keterangan'), 'required');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKmsmanagereward->StartTrans();
                $params = array(
                    $this->user,
                    $post['nama_reward'],
                    $post['keterangan']
                );
                $result = $result && $this->ObjModKmsmanagereward->insertModKmsmanagereward($params);
                $this->ObjModKmsmanagereward->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjModKmsmanagereward->StartTrans();
                $params = array(
                    $post['nama_reward'],
                    $post['keterangan'],
                    $post['id']
                );
                $result = $result && $this->ObjModKmsmanagereward->updateModKmsmanagereward($params);
                $this->ObjModKmsmanagereward->EndTrans($result);   
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
            Messenger::Instance()->Send('mod.kmsmanagereward', 'ModKmsmanagereward', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsmanagereward', 'modkmsmanagereward', 'view', 'html');
        } else {
            Messenger::Instance()->Send('mod.kmsmanagereward', 'inputModKmsmanagereward', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsmanagereward', (empty($post['id'])?'add':'update').'ModKmsmanagereward', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjModKmsmanagereward->deleteModKmsmanagereward($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kmsmanagereward', 'ModKmsmanagereward', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>