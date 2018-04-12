<?php
/**
 * @author Prima Noor
 */
 
class ProcessModKmsreward
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjModKmsreward = GtfwDispt()->load->business('ModKmsreward');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('reward', GtfwLangText('reward'), 'required');
        $Val->set_rules('user', GtfwLangText('user'), 'required');
        $Val->set_rules('nama_reward', GtfwLangText('nama_reward'), 'required');
        $Val->set_rules('keterangan', GtfwLangText('keterangan'), 'required');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKmsreward->StartTrans();
                $params = array(
                    $post['reward'],
                    $post['user'],
                    $post['nama_reward'],
                    $post['keterangan'],
                    $this->user
                );
                $result = $result && $this->ObjModKmsreward->insertModKmsreward($params);
                $this->ObjModKmsreward->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjModKmsreward->StartTrans();
                $params = array(
                    $post['reward'],
                    $post['user'],
                    $post['nama_reward'],
                    $post['keterangan'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjModKmsreward->updateModKmsreward($params);
                $this->ObjModKmsreward->EndTrans($result);   
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
            Messenger::Instance()->Send('mod.kmsreward', 'ModKmsreward', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsreward', 'modkmsreward', 'view', 'html');
        } else {
            Messenger::Instance()->Send('mod.kmsreward', 'inputModKmsreward', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsreward', (empty($post['id'])?'add':'update').'ModKmsreward', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjModKmsreward->deleteModKmsreward($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kmsreward', 'ModKmsreward', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>