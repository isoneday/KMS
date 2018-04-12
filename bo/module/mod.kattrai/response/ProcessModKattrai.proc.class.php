<?php
/**
 * @author Prima Noor
 */
 
class ProcessModKattrai
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjModKattrai = GtfwDispt()->load->business('ModKattrai');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('kat', GtfwLangText('kat'), 'required');
        $Val->set_rules('kat_user', GtfwLangText('kat_user'), 'required');
        $Val->set_rules('kategori', GtfwLangText('kategori'), 'required');
        $Val->set_rules('desc', GtfwLangText('desc'), 'required');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKattrai->StartTrans();
                $params = array(
                    $post['kat'],
                    $post['kat_user'],
                    $post['kategori'],
                    $post['desc'],
                    $this->user
                );
                $result = $result && $this->ObjModKattrai->insertModKattrai($params);
                $this->ObjModKattrai->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjModKattrai->StartTrans();
                $params = array(
                    $post['kat'],
                    $post['kat_user'],
                    $post['kategori'],
                    $post['desc'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjModKattrai->updateModKattrai($params);
                $this->ObjModKattrai->EndTrans($result);   
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
            Messenger::Instance()->Send('mod.kattrai', 'ModKattrai', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kattrai', 'modkattrai', 'view', 'html');
        } else {
            Messenger::Instance()->Send('mod.kattrai', 'inputModKattrai', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kattrai', (empty($post['id'])?'add':'update').'ModKattrai', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjModKattrai->deleteModKattrai($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kattrai', 'ModKattrai', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>